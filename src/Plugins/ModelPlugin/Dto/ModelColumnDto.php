<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;

readonly class ModelColumnDto
{
    public function __construct(
        public AbstractColumn $column,
        public ModelColumnBuilder $modelColumnBuilder,
    ) {
    }
}
