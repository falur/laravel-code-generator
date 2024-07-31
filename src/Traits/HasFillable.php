<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasFillable
{
    protected bool $fillable = true;

    /**
     * @var string|string[]|null
     */
    protected string|array|null $fillableColumn = null;

    /**
     * @return string|string[]|null
     */
    public function getFillableColumn(): string|array|null
    {
        return $this->fillableColumn;
    }

    /**
     * @param string|string[]|null $fillableColumn
     * @return $this
     */
    public function setFillableColumn(string|array|null $fillableColumn): static
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
