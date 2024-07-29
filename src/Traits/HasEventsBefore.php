<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasEventsBefore
{
    /**
     * @var \Closure[]
     */
    protected array $eventsBefore = [];

    /**
     * @return \Closure[]
     */
    public function getEventsBefore(): array
    {
        return $this->eventsBefore;
    }

    /**
     * @param \Closure[] $events
     * @return $this
     */
    public function setEventsBefore(array $events): static
    {
        $this->eventsBefore = $events;

        return $this;
    }

    public function addEventBefore(\Closure $event): static
    {
        $this->eventsBefore[] = $event;

        return $this;
    }

    public function fireEventsBefore(...$arguments): static
    {
        foreach ($this->eventsBefore as $closure) {
            $closure(...$arguments);
        }

        return $this;
    }
}
