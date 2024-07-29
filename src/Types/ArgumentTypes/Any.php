<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types\ArgumentTypes;

final readonly class Any implements ArgumentTypeInterface
{
    public function __construct(
        public mixed $value
    ) {
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
