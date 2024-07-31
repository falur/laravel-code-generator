<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Relations\AbstractRelation;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Columns\Relations\HasMany;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Helpers\RendererHelper;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Dto\MoonshineColumnDto;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;
use GianTiaga\CodeGenerator\Views\ViewInterface;

class MoonshineView implements ViewInterface
{
    /**
     * @param  MoonshineColumnDto[]  $columns
     */
    public function __construct(
        protected TableBuilder $tableBuilder,
        protected array $columns,
    ) {}

    public function imports(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            $result[$column->moonshineColumnBuilder->getMoonshineField()] = 'use '.$column->moonshineColumnBuilder->getMoonshineField();
        }

        if (! $result) {
            return '';
        }

        return implode(";\n", $result).';';
    }

    public function searches(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            if (! $column->column->isInMoonshineResource()) {
                continue;
            }

            if ($column->moonshineColumnBuilder->isSearchable()) {
                $result[] = new Str($column->column->getDatabaseColumn());
            }
        }

        if (! $result) {
            return '';
        }

        return implode(",\n", $result).',';
    }

    public function rules(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            if (! $column->column->isInMoonshineResource()) {
                continue;
            }

            $val = RendererHelper::renderRulesForColumn($column->column);
            if ($val) {
                $result[] = $val;
            }
        }

        if (! $result) {
            return '';
        }

        return implode(",\n", $result);
    }

    public function fields(?\Closure $filter = null, bool $withFluent = true): string
    {
        $result = [];

        if (!$filter) {
            $filter = function (MoonshineColumnDto $column): bool {
                if (! $column->column->isInMoonshineResource()
                    || ! $column->moonshineColumnBuilder->getMoonshineField()
                ) {
                    return false;
                }

                return true;
            };
        }

        foreach ($this->columns as $column) {
            if (!$filter($column)) {
                continue;
            }

            $result[] = RendererHelper::renderCallMethod(
                object: class_basename(
                    $column->moonshineColumnBuilder->getMoonshineField()
                ),
                method: $this->getMethod($column),
                fluent: $withFluent ? $column->moonshineColumnBuilder->getFluent() : [],
                callKind: '::',
                finishSymbol: ',',
            );
        }

        if (! $result) {
            return '';
        }

        return implode("\n", $result);
    }

    private function getMethod(MoonshineColumnDto $column): MethodDto
    {
        if (!$column->column->getName()) {
            $args = null;
        } else if ($column->column instanceof AbstractRelation) {
            $args = [
                ArgumentDto::string($column->column->getLabel()),
                ArgumentDto::string($column->column->getName()),
                $this->getRelatedResource($column),
            ];
        } else {
            $args = [
                ArgumentDto::string($column->column->getLabel()),
                ArgumentDto::string($column->column->getName()),
            ];
        }

        return new MethodDto('make',  $args);
    }

    public function filters(): string
    {
        return $this->fields(filter: function (MoonshineColumnDto $column): bool {
            if (! $column->column->isInMoonshineResource()
                || ! $column->column->isFilterable()
                || ! $column->moonshineColumnBuilder->getMoonshineField()
            ) {
                return false;
            }

            return true;
        }, withFluent: false);
    }

    public function model(): string
    {
        /** @var string $name */
        $name = $this->tableBuilder->getName();

        return ClassFormatter::getModelNameFromTableName($name);
    }

    public function label(): string
    {
        return $this->tableBuilder->getLabel();
    }

    private function getRelatedResource(MoonshineColumnDto $column): ?ArgumentDto
    {
        if ($column->column instanceof AbstractRelation) {
            /** @var string $name */
            $name = $column->column->getRelatedModel();

            return ArgumentDto::any(
                \str(ClassFormatter::getModelNameFromTableName($name))
                    ->prepend('resource: new ')
                    ->append('Resource()')
                    ->toString(),
            );
        }

        return null;
    }
}
