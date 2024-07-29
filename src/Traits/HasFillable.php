<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasFillable
{
    protected bool $fillable = true;
    protected ?string $fillableColumn = null;

    public function getFillableColumn(): ?string
    {
        return $this->fillableColumn;
    }

    public function setFillableColumn(?string $fillableColumn): static
    {
        $this->fillableColumn = $fillableColumn;

        return $this;
    }

    public function isFillable(): bool
    {
        return $this->fillable;
    }

    public function setFillable(bool $fillable): static
    {
        $this->fillable = $fillable;

        return $this;
    }

    public function fillable(): static
    {
        return $this->setFillable(true);
    }
}
