<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders\Target;

interface BuilderInterface
{
    public function getFrom(): string;

    public function getDestination(): string;
}
