<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasEventAfter
{
    /**
     * @var \Closure[]
     */
    protected array $eventsAfter = [];

    /**
     * @return \Closure[]
     */
    public function getEventsAfter(): array
    {
        return $this->eventsAfter;
    }

    /**
     * @param  \Closure[]  $eventsAfter
     * @return $this
     */
    public function setEventAfter(array $eventsAfter): static
    {
        $this->eventsAfter = $eventsAfter;

        return $this;
    }

    public function addEventAfter(\Closure $event): static
    {
        $this->eventsAfter[] = $event;

        return $this;
    }

    public function fireEventAfter(mixed ...$arguments): static
    {
        foreach ($this->eventsAfter as $closure) {
            $closure(...$arguments);
        }

        return $this;
    }
}
