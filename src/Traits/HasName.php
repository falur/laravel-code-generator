<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasName
{
    protected ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
