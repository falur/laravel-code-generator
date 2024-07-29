<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Fields;

use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class Timestamps extends AbstractField
{
    protected bool $inMoonshineResource = false;
}
