<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Traits;

trait HasInMoonshineResource
{
    protected bool $inMoonshineResource = true;

    public function isInMoonshineResource(): bool
    {
        return $this->inMoonshineResource;
    }

    public function setInMoonshineResource(bool $inMoonshineResource): static
    {
        $this->inMoonshineResource = $inMoonshineResource;

        return $this;
    }
}
