<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasSearchable
{
    protected bool $searchable = false;

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    public function setSearchable(bool $searchable): static
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function searchable(): static
    {
        $this->searchable = true;

        return $this;
    }
}
