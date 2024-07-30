<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasDefaultValue
{
    protected mixed $defaultValue = null;

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(mixed $defaultValue): static
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }
}
