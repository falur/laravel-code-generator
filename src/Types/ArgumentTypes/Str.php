<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types\ArgumentTypes;

final readonly class Str implements ArgumentTypeInterface
{
    public function __construct(
        public string $value
    ) {
    }

    public function __toString(): string
    {
        return \Illuminate\Support\Str::wrap($this->value, "'");
    }
}
