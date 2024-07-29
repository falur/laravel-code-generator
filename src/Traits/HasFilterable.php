<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasFilterable
{
    protected bool $filterable = false;

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    public function setFilterable(bool $filterable): static
    {
        $this->filterable = $filterable;
        return $this;
    }

    public function filterable(): static
    {
        $this->filterable = true;

        return $this;
    }
}
