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

            $val = RendererHelper::renderRulesForColumn($column->column, $this->tableBuilder);
            if ($val) {
                $result[] = $val;
            }
        }

        if (! $result) {
            return '';
        }

        return implode(",\n", $result);
    }

    /**
     * @param \Closure|null $filter
     * @param MethodDto[]|\Closure $fluent
     * @return string
     */
    public function fields(?\Closure $filter = null, array|\Closure|null $fluent = []): string
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

            if (is_null($fluent)) {
                $newFluent = [];
            } else if (is_callable($fluent)) {
                $newFluent = collect($column->moonshineColumnBuilder->getFluent())
                    ->filter($fluent)
                    ->toArray();
            } else if (is_array($fluent) && $fluent) {
                $newFluent = $fluent;
            } else {
                $newFluent = $column->moonshineColumnBuilder->getFluent();
            }

            $result[] = RendererHelper::renderCallMethod(
                object: class_basename(
                    $column->moonshineColumnBuilder->getMoonshineField()
                ),
                method: $this->getMethod($column),
                fluent: $newFluent,
                callKind: '::',
                finishSymbol: ", \n",
            );
        }

        if (! $result) {
            return '';
        }

        return trim(implode("\n", array_filter($result)));
    }

    public function indexFields(): string
    {
        return $this->fields(fluent: fn (MethodDto $dto) => $dto->name === 'sortable');
    }

    public function formFields(): string
    {
        return $this->fields(fluent: fn (MethodDto $dto) => $dto->name !== 'sortable');
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
        }, fluent: [
            new MethodDto('nullable')
        ]);
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
                    ->prepend('resource: ')
                    ->append('Resource::class')
                    ->toString(),
            );
        }

        return null;
    }
}
