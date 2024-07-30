<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait Makeable
{
    public static function make(mixed ...$arguments): static
    {
        // @phpstan-ignore-next-line
        $cls = new static(...$arguments);
        $cls->afterMake();

        return $cls;
    }

    protected function afterMake(): void {}
}
