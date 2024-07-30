<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Dto;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineColumnBuilder;

final readonly class MoonshineColumnDto
{
    public function __construct(
        public AbstractColumn $column,
        public MoonshineColumnBuilder $moonshineColumnBuilder,
    ) {}
}
