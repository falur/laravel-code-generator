<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasIndex
{
    protected bool $index = false;

    public function isIndex(): bool
    {
        return $this->index;
    }

    public function setIndex(bool $index): static
    {
        $this->index = $index;

        return $this;
    }

    public function index(): static
    {
        $this->index = true;

        return $this;
    }
}
