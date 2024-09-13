<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\FactoryPlugin\Traits;

use GianTiaga\CodeGenerator\Plugins\FactoryPlugin\Builders\FactoryBuilder;
use GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Builders\PolicyBuilder;

trait HasFactoryBuilder
{
    protected ?FactoryBuilder $factoryBuilder = null;

    public function getFactoryBuilder(): ?FactoryBuilder
    {
        return $this->factoryBuilder;
    }

    public function setFactoryBuilder(?FactoryBuilder $factoryBuilder): static
    {
        $this->factoryBuilder = $factoryBuilder;

        return $this;
    }
}
