<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Traits;

trait HasInModel
{
    protected bool $inModel = true;

    public function isInModel(): bool
    {
        return $this->inModel;
    }

    public function setInModel(bool $inModel): static
    {
        $this->inModel = $inModel;

        return $this;
    }
}
