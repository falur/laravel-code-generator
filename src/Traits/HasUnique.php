<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasUnique
{
    protected bool $unique = false;

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function setUnique(bool $unique): static
    {
        $this->unique = $unique;
        return $this;
    }

    public function unique(): static
    {
        $this->unique = true;

        return $this;
    }
}
