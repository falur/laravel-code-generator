<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasSortable
{
    protected bool $sortable = false;

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function setSortable(bool $sortable): static
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function sortable(): static
    {
        $this->sortable = true;

        return $this;
    }
}
