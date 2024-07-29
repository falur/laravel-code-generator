<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasCast
{
    protected mixed $cast = null;

    public function getCast(): mixed
    {
        return $this->cast;
    }

    public function setCast(mixed $cast): static
    {
        $this->cast = $cast;

        return $this;
    }
}
