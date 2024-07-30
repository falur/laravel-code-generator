<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\ClassNameDto;

trait HasImplements
{
    /**
     * @var ClassNameDto[]
     */
    protected array $implements = [];

    /**
     * @return ClassNameDto[]
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * @param  ClassNameDto[]  $implements
     * @return $this
     */
    public function setImplements(array $implements): static
    {
        $this->implements = $implements;

        return $this;
    }

    /**
     * @return $this
     */
    public function addImplement(ClassNameDto $implement): static
    {
        $this->implements[] = $implement;

        return $this;
    }
}
