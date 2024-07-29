<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\ClassNameDto;

trait HasExtends
{
    public ?ClassNameDto $extends = null;

    public function getExtends(): ?ClassNameDto
    {
        return $this->extends;
    }

    public function setExtends(?ClassNameDto $extends): static
    {
        $this->extends = $extends;

        return $this;
    }
}
