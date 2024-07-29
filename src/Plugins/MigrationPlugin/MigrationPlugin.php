<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin;

use GianTiaga\CodeGenerator\Builders\CodeGenerator;
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
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\IndexDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\AbstractPlugin;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationBuilder;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Dto\MigrationColumnDto;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Helpers\MigrationCounter;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Views\MigrationsView;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Renderers\Renderer;
use Illuminate\Support\Str;

class MigrationPlugin extends AbstractPlugin
{
    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        foreach ($this->codeGenerator->getTables() as $table) {
            $migrationBuilder = $table->getMigrationBuilder();
            if (!$migrationBuilder) {
                continue;
            }

            $columns = $this->makeColumnsFromTable($table);

            $this->before($columns, $table);

            $renderer = new Renderer(
                new MigrationsView($table, $columns),
                $migrationBuilder,
            );

            $renderer->copyRendered(
                $this->getMigrationFileName(
                    $table,
                ),
            );

            $this->after($columns, $table);
        }
    }

    /**
     * @param MigrationColumnDto[] $columns
     * @param TableBuilder $tableBuilder
     * @return void
     */
    public function before(array $columns, TableBuilder $tableBuilder): void
    {
        foreach ($columns as $column) {
            $column->migrationColumnBuilder->fireEventsBefore($tableBuilder, $column);
        }
    }

    /**
     * @param MigrationColumnDto[] $columns
     * @param TableBuilder $tableBuilder
     * @return void
     */
    public function after(array $columns, TableBuilder $tableBuilder): void
    {
        foreach ($columns as $column) {
            $column->migrationColumnBuilder->fireEventAfter($tableBuilder, $column);
        }
    }

    /**
     * @param TableBuilder $tableBuilder
     * @return string
     */
    public function getMigrationFileName(TableBuilder $tableBuilder): string
    {
        $num = vsprintf("0000_00_00_00_%04d", [MigrationCounter::next()]);
        return "{$num}_create_{$tableBuilder->getName()}_table.php";
    }

    /**
     * @param TableBuilder $tableBuilder
     * @return MigrationColumnDto[]
     */
    protected function makeColumnsFromTable(TableBuilder $tableBuilder): array
    {
        $columns = [];

        foreach ($tableBuilder->getColumns() as $column) {
            $columnBuilder = $this->getColumnBuilderByColumn($column);
            if (!$column->isInMigration() || !$columnBuilder) {
                continue;
            }

            $columns[] = new MigrationColumnDto($column, $columnBuilder);
        }

        return $columns;
    }

    /**
     * @param AbstractColumn $column
     * @return MigrationColumnBuilder|null
     */
    protected function getColumnBuilderByColumn(AbstractColumn $column): ?MigrationColumnBuilder
    {
        return match ($column::class) {
            ID::class => MigrationColumnBuilder::make(
                new MethodDto(name: 'id'),
            ),

            Boolean::class => MigrationColumnBuilder::makeFromColumn(
                'boolean',
                $column,
            ),

            Text::class,
            Color::class,
            Hidden::class,
            Email::class,
            Password::class,
            Phone::class,
            Slug::class
                => MigrationColumnBuilder::makeFromColumn(
                    'string',
                    $column,
            ),

            Number::class => MigrationColumnBuilder::makeFromColumn(
                $column->getType()->name,
                $column,
            ),

            TextArea::class,
            WYSIWYG::class
                => MigrationColumnBuilder::makeFromColumn(
                    'text',
                    $column,
            ),

            DateTime::class
                => MigrationColumnBuilder::makeFromColumn(
                    $column->getType()->name,
                    $column,
            ),

            Json::class => MigrationColumnBuilder::makeFromColumn(
                'json',
                $column,
            ),

            BelongsTo::class => MigrationColumnBuilder::make(
                new MethodDto('foreignIdFor', [
                    ArgumentDto::any(
                        ClassFormatter::getFullRelationNameFromFieldName(
                            $column->getName(),
                        ),
                    ),
                ]),
            )
                ->addFluentWhen(!$column->isRequired(), new MethodDto('nullable'))
                ->addFluent(new MethodDto('constrained'))
                ->addFluent(new MethodDto('cascadeOnUpdate'))
                ->addFluent(new MethodDto('cascadeOnDelete')),

            BelongsToMany::class => MigrationColumnBuilder::make()
                ->addEventAfter(function (TableBuilder $tableBuilder) use ($column) {
                    $field1 = Str::singular($tableBuilder->getName());
                    $field2 = Str::singular($column->getName());
                    $table = collect([$field1, $field2])
                        ->sort()
                        ->implode('_');

                    CodeGenerator::make()
                        ->registerPlugins([
                            new MigrationPlugin(),
                        ])
                        ->addTable(
                            TableBuilder::make($table)
                                ->setMigrationBuilder(
                                    MigrationBuilder::make()
                                        ->addToUniques(new IndexDto(["{$field1}_id", "{$field2}_id"]))
                                )
                                ->setColumns([
                                    BelongsTo::make($field1)
                                        ->required(),

                                    BelongsTo::make($field2)
                                        ->required(),
                                ]),
                        )
                        ->generate();
                }),

            Timestamps::class => MigrationColumnBuilder::make(
                new MethodDto(name: 'timestamps'),
            ),

            default => null,
        };
    }
}
