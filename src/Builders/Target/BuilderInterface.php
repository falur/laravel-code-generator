<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders\Target;

interface BuilderInterface
{
    /**
     * @return string
     */
    public function getFrom(): string;

    /**
     * @return string
     */
    public function getDestination(): string;
}
