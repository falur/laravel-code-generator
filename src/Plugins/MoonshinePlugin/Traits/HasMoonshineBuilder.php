<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Traits;

use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineBuilder;

trait HasMoonshineBuilder
{
    protected ?MoonshineBuilder $moonshineBuilder = null;

    public function getMoonshineBuilder(): ?MoonshineBuilder
    {
        return $this->moonshineBuilder;
    }

    public function setMoonshineBuilder(?MoonshineBuilder $moonshineBuilder): static
    {
        $this->moonshineBuilder = $moonshineBuilder;

        return $this;
    }
}
