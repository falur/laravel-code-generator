<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Dto;

final readonly class IndexDto
{
    /**
     * @param string[] $fields
     * @param string|null $name
     */
    public function __construct(
        public array $fields,
        public ?string $name = null,
    ) {
    }
}
