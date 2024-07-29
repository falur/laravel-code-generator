<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\IndexDto;

trait HasIndexes
{
    /**
     * @var IndexDto[]
     */
    protected array $indexes = [];

    /**
     * @return IndexDto[]
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }

    /**
     * @param IndexDto[] $indexes
     * @return $this
     */
    public function setIndexes(array $indexes): static
    {
        $this->indexes = $indexes;

        return $this;
    }

    /**
     * @param IndexDto $index
     * @return $this
     */
    public function addIndex(IndexDto $index): static
    {
        $this->indexes[] = $index;

        return $this;
    }
}
