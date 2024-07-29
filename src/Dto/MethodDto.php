<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Dto;

final readonly class MethodDto
{
    /**
     * @param string $name
     * @param ?ArgumentDto[] $args
     */
    public function __construct(
        public string $name,
        public ?array $args = null,
    ) {
    }
}
