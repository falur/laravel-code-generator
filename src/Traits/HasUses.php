<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\ClassNameDto;

trait HasUses
{
    /**
     * @var ClassNameDto[]
     */
    protected array $uses = [];

    /**
     * @return ClassNameDto[]
     */
    public function getUses(): array
    {
        return $this->uses;
    }

    /**
     * @param ClassNameDto[] $uses
     * @return $this
     */
    public function setUses(array $uses): static
    {
        $this->uses = $uses;

        return $this;
    }

    /**
     * @param ClassNameDto $use
     * @return $this
     */
    public function addUse(ClassNameDto $use): static
    {
        $this->uses[] = $use;

        return $this;
    }
}
