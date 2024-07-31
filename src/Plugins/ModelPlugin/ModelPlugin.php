<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Columns\Fields\Boolean;
use GianTiaga\CodeGenerator\Columns\Fields\Color;
use GianTiaga\CodeGenerator\Columns\Fields\DateTime;
use GianTiaga\CodeGenerator\Columns\Fields\Email;
use GianTiaga\CodeGenerator\Columns\Fields\Hidden;
use GianTiaga\CodeGenerator\Columns\Fields\ID;
use GianTiaga\CodeGenerator\Columns\Fields\Json;
use GianTiaga\CodeGenerator\Columns\Fields\Number;
use GianTiaga\CodeGenerator\Columns\Fields\Password;
use GianTiaga\CodeGenerator\Columns\Fields\Phone;
use GianTiaga\CodeGenerator\Columns\Fields\Slug;
use GianTiaga\CodeGenerator\Columns\Fields\Text;
use GianTiaga\CodeGenerator\Columns\Fields\TextArea;
use GianTiaga\CodeGenerator\Columns\Fields\Timestamps;
use GianTiaga\CodeGenerator\Columns\Fields\WYSIWYG;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsTo;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Columns\Relations\HasMany;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\AbstractPlugin;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView;
use GianTiaga\CodeGenerator\Renderers\Renderer;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class ModelPlugin extends AbstractPlugin
{
    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        foreach ($this->codeGenerator->getTables() as $table) {
            $modelBuilder = $table->getModelBuilder();
            if (! $modelBuilder) {
                continue;
            }

            $columns = $this->makeColumnsFromTable($table);

            $this->before($columns, $table);

            $renderer = new Renderer(
                new ModelsView($table, $columns),
                $modelBuilder,
            );

            $renderer->copyRendered(
                $this->getModelFileName(
                    $table,
                ),
            );

            $this->after($columns, $table);
        }
    }

    /**
     * @param  ModelColumnDto[]  $columns
     */
    public function before(array $columns, TableBuilder $tableBuilder): void
    {
        foreach ($columns as $column) {
            $column->modelColumnBuilder->fireEventsBefore($tableBuilder, $column);
        }
    }

    /**
     * @param  ModelColumnDto[]  $columns
     */
    public function after(array $columns, TableBuilder $tableBuilder): void
    {
        foreach ($columns as $column) {
            $column->modelColumnBuilder->fireEventAfter($tableBuilder, $column);
        }
    }

    public function getModelFileName(TableBuilder $tableBuilder): string
    {
        return ClassFormatter::getModelNameFromTableName($tableBuilder->getName()).'.php';
    }

    /**
     * @return ModelColumnDto[]
     */
    protected function makeColumnsFromTable(TableBuilder $tableBuilder): array
    {
        $columns = [];

        foreach ($tableBuilder->getColumns() as $column) {
            $columnBuilder = $this->getColumnBuilderByColumn($column);
            if (! $column->isInModel() || ! $columnBuilder) {
                continue;
            }

            $columns[] = new ModelColumnDto($column, $columnBuilder);
        }

        return $columns;
    }

    protected function getColumnBuilderByColumn(AbstractColumn $column): ?ModelColumnBuilder
    {
        return match ($column::class) {
            ID::class => ModelColumnBuilder::make($column)
                ->setFillable(false),

            Boolean::class => ModelColumnBuilder::makeFromColumn($column)
                ->setCast(new Str('bool')),

            Text::class,
            Color::class,
            Hidden::class,
            Email::class,
            Password::class,
            Phone::class,
            Slug::class,
            TextArea::class,
            WYSIWYG::class => ModelColumnBuilder::makeFromColumn($column),

            Number::class,
            BelongsTo::class => ModelColumnBuilder::makeFromColumn($column)
                ->setCast(new Str('int')),

            DateTime::class => ModelColumnBuilder::makeFromColumn($column)
                ->setCast(new Str('immutable_datetime')),

            Json::class => ModelColumnBuilder::makeFromColumn($column)
                ->setCast(new Str('array')),

            HasMany::class,
            BelongsToMany::class => ModelColumnBuilder::make()
                ->setFillable(false),

            Timestamps::class => ModelColumnBuilder::makeFromColumn($column)
                ->setFillableColumn(['updated_at', 'created_at']),

            default => null,
        };
    }
}
