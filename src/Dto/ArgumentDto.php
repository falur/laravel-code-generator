<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Dto;

use GianTiaga\CodeGenerator\Types\ArgumentTypes\Any;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\ArgumentTypeInterface;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Arr;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

final readonly class ArgumentDto
{
    public function __construct(
        public ArgumentTypeInterface $value
    ) {
    }

    /**
     * @param mixed[]|null $value
     * @return self
     */
    public static function array(?array $value): self
    {
        return new self(new Arr($value));
    }

    public static function string(?string $value): self
    {
        return new self(new Str((string)$value));
    }

    public static function any(mixed $value): self
    {
        return new self(new Any($value));
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
