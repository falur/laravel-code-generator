<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Views;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Helpers\RendererHelper;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Dto\MigrationColumnDto;
use GianTiaga\CodeGenerator\Views\ViewInterface;
use Illuminate\Support\Arr;

class MigrationsView implements ViewInterface
{
    /**
     * @param  MigrationColumnDto[]  $columns
     */
    public function __construct(
        protected TableBuilder $tableBuilder,
        protected array $columns,
    ) {}

    public function tableName(): string
    {
        return $this->tableBuilder->getName();
    }

    public function columns(): string
    {
        $result = '';

        foreach ($this->columns as $column) {
            $col = $this->column($column);

            if ($col) {
                $result .= $col;
                $result .= "\n";
            }
        }

        return trim($result);
    }

    public function column(MigrationColumnDto $column): ?string
    {
        $migrationColumnBuilder = $column->migrationColumnBuilder;

        if (! $migrationColumnBuilder->getMethod()) {
            return null;
        }

        return RendererHelper::renderCallMethod(
            '$table',
            $migrationColumnBuilder->getMethod(),
            $migrationColumnBuilder->getFluent(),
        );
    }

    public function indexes(): string
    {
        $result = '';

        foreach ($this->tableBuilder->getMigrationBuilder()->getIndexes() as $index) {
            $result .= RendererHelper::renderCallMethod(
                '$table',
                new MethodDto('index', [
                    ArgumentDto::array(
                        Arr::map($index->fields, function (string $v) {
                            return ArgumentDto::string($v);
                        }),
                    ),
                ]),
            );
        }

        return $result;
    }

    public function uniques(): string
    {
        $result = '';

        foreach ($this->tableBuilder->getMigrationBuilder()->getUniques() as $index) {
            $result .= RendererHelper::renderCallMethod(
                '$table',
                new MethodDto('unique', [
                    ArgumentDto::array(
                        Arr::map($index->fields, function (string $v) {
                            return ArgumentDto::string($v);
                        }),
                    ),
                ]),
            );
        }

        return $result;
    }

    public function getTableBuilder(): TableBuilder
    {
        return $this->tableBuilder;
    }
}
