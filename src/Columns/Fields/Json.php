<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Fields;

use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class Json extends AbstractField
{
    public function defaultModelColumnBuilder(): ?\Closure
    {
        return fn () => ModelColumnBuilder::makeFromColumn($this)
            ->setCast(new Str('array'));
    }
}
