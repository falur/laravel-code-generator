<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait Makeable
{
    public static function make(...$arguments): static
    {
        $cls = new static(...$arguments);
        $cls->afterMake();

        return $cls;
    }

    protected function afterMake(): void
    {

    }
}
