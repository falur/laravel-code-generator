<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders\Target;

use GianTiaga\CodeGenerator\Traits\Makeable;

abstract class AbstractBuilder implements BuilderInterface
{
    use Makeable;

    /**
     * @var string
     */
    protected string $destination;

    /**
     * @var string
     */
    protected string $from;

    /**
     * @return string
     */
    abstract protected function defaultDestination(): string;

    /**
     * @return string
     */
    abstract protected function defaultFrom(): string;

    protected function __construct() {}

    /**
     * @return void
     */
    protected function afterMake(): void
    {
        $this->setDestination($this->defaultDestination());
        $this->setFrom($this->defaultFrom());
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return $this
     */
    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function setFrom(string $from): static
    {
        $this->from = $from;

        return $this;
    }
}
