<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\ClassNameDto;

trait HasImports
{
    /**
     * @var ClassNameDto[]
     */
    protected array $imports = [];

    /**
     * @return ClassNameDto[]
     */
    public function getImports(): array
    {
        return $this->imports;
    }

    /**
     * @param  ClassNameDto[]  $imports
     * @return $this
     */
    public function setImports(array $imports): static
    {
        $this->imports = $imports;

        return $this;
    }

    /**
     * @return $this
     */
    public function addImport(ClassNameDto $use): static
    {
        $this->imports[] = $use;

        return $this;
    }
}
