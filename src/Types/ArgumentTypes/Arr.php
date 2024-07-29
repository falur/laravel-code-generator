<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types\ArgumentTypes;

final readonly class Arr implements ArgumentTypeInterface
{
    public function __construct(
        public ?array $value
    ) {
    }

    public function __toString(): string
    {
        if (!$this->value) {
            return '';
        }

        return '[' . implode(', ', $this->value) . ']';
    }
}
