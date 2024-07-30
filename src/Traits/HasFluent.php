<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Dto\MethodDto;

trait HasFluent
{
    /**
     * @var MethodDto[]
     */
    protected array $fluent = [];

    /**
     * @return MethodDto[]
     */
    public function getFluent(): array
    {
        return $this->fluent;
    }

    /**
     * @param  MethodDto[]  $fluent
     * @return $this
     */
    public function setFluent(array $fluent): static
    {
        $this->fluent = $fluent;

        return $this;
    }

    /**
     * @return $this
     */
    public function addFluent(MethodDto $fluent): static
    {
        $this->fluent[] = $fluent;

        return $this;
    }

    /**
     * @return $this
     */
    public function addFluentWhen(bool $bool, MethodDto $fluent): static
    {
        if ($bool) {
            $this->fluent[] = $fluent;
        }

        return $this;
    }
}
