<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Dto;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationColumnBuilder;

readonly class MigrationColumnDto
{
    public function __construct(
        public AbstractColumn $column,
        public MigrationColumnBuilder $migrationColumnBuilder,
    ) {
    }
}
