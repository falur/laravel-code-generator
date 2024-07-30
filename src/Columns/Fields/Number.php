<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Fields;

use GianTiaga\CodeGenerator\Types\NumberType;

class Number extends AbstractField
{
    protected NumberType $type = NumberType::unsignedBigInteger;

    public function getType(): NumberType
    {
        return $this->type;
    }

    public function setType(NumberType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
