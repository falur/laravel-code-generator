<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types\ArgumentTypes;

final readonly class Any implements ArgumentTypeInterface
{
    public function __construct(
        public string|null|int|bool $value
    ) {}

    public function __toString(): string
    {
        if (is_null($this->value)) {
            return 'null';
        }

        if (is_bool($this->value)) {
            return $this->value ? 'true' : 'false';
        }

        return (string) $this->value;
    }
}
