<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\IndexDto;

trait HasUniques
{
    /**
     * @var IndexDto[]
     */
    protected array $uniques = [];

    /**
     * @return IndexDto[]
     */
    public function getUniques(): array
    {
        return $this->uniques;
    }

    /**
     * @param  IndexDto[]  $unique
     * @return $this
     */
    public function setUniques(array $unique): static
    {
        $this->uniques = $unique;

        return $this;
    }

    /**
     * @return $this
     */
    public function addToUniques(IndexDto $unique): static
    {
        $this->uniques[] = $unique;

        return $this;
    }
}
