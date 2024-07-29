<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use Illuminate\Support\Str;

trait HasMoonshineFieldClass
{
    protected ?string $moonshineFieldClass = null;

    abstract public function defaultMoonshineFieldClass(): string;

    public function getShortMoonshineFieldClass(): string
    {
        return Str::afterLast($this->getMoonshineFieldClass(), '\\');
    }

    public function getMoonshineFieldClass(): ?string
    {
        return $this->moonshineFieldClass;
    }

    public function setMoonshineFieldClass(?string $moonshineFieldClass): static
    {
        $this->moonshineFieldClass = $moonshineFieldClass;
        return $this;
    }
}
