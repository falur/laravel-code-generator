<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Columns\Fields\Boolean;
use GianTiaga\CodeGenerator\Columns\Fields\Color;
use GianTiaga\CodeGenerator\Columns\Fields\DateTime;
use GianTiaga\CodeGenerator\Columns\Fields\Email;
use GianTiaga\CodeGenerator\Columns\Fields\File;
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
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Dto\MoonshineColumnDto;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views\MoonshineView;
use GianTiaga\CodeGenerator\Renderers\Renderer;
use GianTiaga\MoonshineFile\Fields\SpatieUppyFile;

class MoonshinePlugin extends AbstractPlugin
{
    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        foreach ($this->codeGenerator->getTables() as $table) {
            $moonshineBuilder = $table->getMoonshineBuilder();

            if (!$moonshineBuilder) {
                continue;
            }

            $columns = $this->makeColumnsFromTable($table);
            $renderer = new Renderer(
                new MoonshineView($table, $columns),
                $moonshineBuilder,
            );

            $renderer->copyRendered(
                $this->getMoonshineFilename(
                    $table,
                ),
            );
        }
    }

    public function getMoonshineFilename(TableBuilder $table): string
    {
        return str(ClassFormatter::getClassNameFromTableName($table->getName()))
            ->append('Resource.php')
            ->toString();
    }

    /**
     * @return MoonshineColumnDto[]
     */
    public function makeColumnsFromTable(TableBuilder $table): array
    {
        $columns = [];

        foreach ($table->getColumns() as $column) {
            $columnBuilder = $this->getColumnBuilderByColumn($column);
            if (!$column->isInMoonshineResource() || !$columnBuilder) {
                continue;
            }

            $columns[] = new MoonshineColumnDto($column, $columnBuilder);
        }

        return $columns;
    }

    /**
     * @param AbstractColumn $column
     * @return ModelColumnBuilder|null
     */
    protected function getColumnBuilderByColumn(AbstractColumn $column): ?MoonshineColumnBuilder
    {
        return match ($column::class) {
            ID::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\ID::class
            ),

            Boolean::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Switcher::class
            ),

            Text::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Text::class
            ),

            Color::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Color::class
            ),

            Hidden::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Hidden::class
            ),

            Email::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Email::class
            ),

            Password::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Password::class
            ),

            Phone::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Phone::class
            ),

            Slug::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Slug::class
            ),

            TextArea::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Textarea::class
            ),

            WYSIWYG::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\TinyMce::class
            ),

            Number::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Number::class
            ),

            DateTime::class => MoonshineColumnBuilder::makeFromColumn(
                $column, \MoonShine\Fields\Date::class
            ),

            Json::class => MoonshineColumnBuilder::makeFromColumn(
                $column, \MoonShine\Fields\Json::class),

            BelongsToMany::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Relationships\BelongsToMany::class
            ),

            HasMany::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Relationships\HasMany::class
            ),

            BelongsTo::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                \MoonShine\Fields\Relationships\BelongsTo::class
            ),

            File::class => MoonshineColumnBuilder::makeFromColumn(
                $column,
                SpatieUppyFile::class,
            ),

            Timestamps::class => null,

            default => null,
        };
    }
}
