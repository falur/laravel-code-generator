<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Dto\MigrationColumnDto;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;
use GianTiaga\CodeGenerator\Views\ViewInterface;

class ModelsView implements ViewInterface
{
    /**
     * @param  ModelColumnDto[]  $columns
     */
    public function __construct(
        protected TableBuilder $tableBuilder,
        protected array $columns,
    ) {}

    /**
     * @return MigrationColumnDto[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getTableBuilder(): TableBuilder
    {
        return $this->tableBuilder;
    }

    public function className(): string
    {
        return ClassFormatter::getClassNameFromTableName(
            $this->tableBuilder->getName(),
        );
    }

    public function imports(): string
    {
        $modelBuilder = $this->tableBuilder->getModelBuilder();
        /** @var ClassNameDto[] $classes */
        $classes = array_merge(
            [$modelBuilder->getExtends()],
            $modelBuilder->getImplements(),
            $modelBuilder->getUses(),
        );
        $classes = array_filter($classes);

        $result = [];

        foreach ($classes as $class) {
            $result[] = 'use '.$class->name.($class->as ? ' as '.$class->as : '').';';
        }

        return implode("\n", $result);
    }

    public function uses(): string
    {
        $result = [];
        foreach ($this->tableBuilder->getModelBuilder()->getUses() as $use) {
            $result[] = 'use '.class_basename($use->value()).';';
        }

        return implode("\n", $result);
    }

    public function implements(): string
    {
        $result = [];
        foreach ($this->tableBuilder->getModelBuilder()->getImplements() as $implement) {
            $result[] = class_basename($implement->value());
        }

        return $result ? ('implements '.implode(',', $result)) : '';
    }

    public function extends(): string
    {
        $extends = $this->tableBuilder->getModelBuilder()->getExtends();

        if ($extends) {
            return 'extends '.class_basename($extends->value());
        }

        return '';
    }

    public function fillable(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            if ($column->modelColumnBuilder->isFillable()) {
                $result[] = $column->modelColumnBuilder->getFillableColumn();
            }
        }

        return implode(",\n", $result).',';
    }

    public function casts(): string
    {
        $result = [];
        foreach ($this->columns as $column) {
            $name = $column->column->getName();
            $cast = $column->modelColumnBuilder->getCast();
            if ($cast && $name) {
                $result[] = new Str($column->column->getName()).'=> '.$cast;
            }
        }

        return $result ? implode(",\n", $result).',' : '';
    }
}
