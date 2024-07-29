<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasLabel
{
    protected ?string $label = null;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;
        return $this;
    }
}
