<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasRequired
{
    protected bool $required = false;

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): static
    {
        $this->required = $required;

        return $this;
    }

    public function required(): static
    {
        $this->required = true;

        return $this;
    }
}
