<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Columns\Relations\HasMany;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Helpers\RendererHelper;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Dto\MoonshineColumnDto;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;
use GianTiaga\CodeGenerator\Views\ViewInterface;
use MoonShine\Fields\Relationships\ModelRelationField;

class MoonshineView implements ViewInterface
{
    /**
     * @param TableBuilder $tableBuilder
     * @param MoonshineColumnDto[] $columns
     */
    public function __construct(
        protected TableBuilder $tableBuilder,
        protected array $columns,
    ) {
    }

    public function imports(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            $result[$column->moonshineColumnBuilder->getMoonshineField()] = 'use ' . $column->moonshineColumnBuilder->getMoonshineField();
        }

        if (!$result) {
            return '';
        }

        return implode(";\n", $result) . ';';
    }

    public function searches(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            if (!$column->column->isInMoonshineResource()) {
                continue;
            }

            if ($column->moonshineColumnBuilder->isSearchable()) {
                $result[] = new Str($column->column->getName());
            }
        }

        if (!$result) {
            return '';
        }

        return implode(",\n", $result) . ',';
    }

    public function rules(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            if (!$column->column->isInMoonshineResource()) {
                continue;
            }

            $val =  RendererHelper::renderRulesForColumn($column->column);
            if ($val) {
                $result[] = $val;
            }
        }

        if (!$result) {
            return '';
        }

        return implode(",\n", $result);
    }

    public function fields(): string
    {
        $result = [];

        foreach ($this->columns as $column) {
            if (!$column->column->isInMoonshineResource()) {
                continue;
            }

            $result[] = RendererHelper::renderCallMethod(
                class_basename($column->moonshineColumnBuilder->getMoonshineField()),
                new MethodDto('make', $column->column->getName() ? [
                    ArgumentDto::string($column->column->getLabel()),
                    ArgumentDto::string($column->column->getName()),
                    $this->getRelatedResource($column),
                ] : null),
                $column->moonshineColumnBuilder->getFluent(),
                '::',
                ',',
            );
        }

        if (!$result) {
            return '';
        }

        return implode("\n", $result);
    }

    public function filters(): string
    {
        $result = [];

        foreach ($this->columns as $column) {
            if (!$column->column->isInMoonshineResource() || !$column->column->isFilterable()) {
                continue;
            }

            $result[] = RendererHelper::renderCallMethod(
                object: class_basename($column->moonshineColumnBuilder->getMoonshineField()),
                method: new MethodDto('make', $column->column->getName() ? [
                    ArgumentDto::string($column->column->getLabel()),
                    ArgumentDto::string($column->column->getName()),
                    $this->getRelatedResource($column),
                ] : null),
                callKind: '::',
                finishSymbol: ',',
            );
        }

        if (!$result) {
            return '';
        }

        return implode("\n", $result);
    }

    public function model(): string
    {
        return ClassFormatter::getClassNameFromTableName($this->tableBuilder->getName());
    }

    public function label(): string
    {
        return $this->tableBuilder->getLabel();
    }

    private function getRelatedResource(MoonshineColumnDto $column): ?ArgumentDto
    {
        if ($column->column instanceof HasMany || $column->column instanceof BelongsToMany) {
            return ArgumentDto::any(
                \str(ClassFormatter::getClassNameFromTableName($column->column->getName()))
                    ->append('Resource::class')
                    ->toString(),
            );
        }

        return null;
    }
}
