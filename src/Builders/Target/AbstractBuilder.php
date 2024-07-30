<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders\Target;

use GianTiaga\CodeGenerator\Traits\Makeable;

abstract class AbstractBuilder implements BuilderInterface
{
    use Makeable;

    protected string $destination;

    protected string $from;

    abstract protected function defaultDestination(): string;

    abstract protected function defaultFrom(): string;

    protected function __construct() {}

    protected function afterMake(): void
    {
        $this->setDestination($this->defaultDestination());
        $this->setFrom($this->defaultFrom());
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return $this
     */
    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return $this
     */
    public function setFrom(string $from): static
    {
        $this->from = $from;

        return $this;
    }
}
