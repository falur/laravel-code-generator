<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Dto;

final readonly class ClassNameDto
{
    public function __construct(
        public string $name,
        public ?string $as = null,
    ) {
    }

    public function value(): string
    {
        if ($this->as) {
            return $this->as;
        }

        return $this->name;
    }
}
