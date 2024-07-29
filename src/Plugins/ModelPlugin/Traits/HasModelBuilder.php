<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Traits;

use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;

trait HasModelBuilder
{
    protected ?ModelBuilder $modelBuilder = null;

    public function getModelBuilder(): ?ModelBuilder
    {
        return $this->modelBuilder;
    }

    public function setModelBuilder(?ModelBuilder $modelBuilder): static
    {
        $this->modelBuilder = $modelBuilder;

        return $this;
    }
}
