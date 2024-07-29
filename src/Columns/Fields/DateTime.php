<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Fields;

use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;
use GianTiaga\CodeGenerator\Types\DateTimeType;

class DateTime extends AbstractField
{
    protected DateTimeType $type = DateTimeType::timestamp;

    public function getType(): DateTimeType
    {
        return $this->type;
    }

    public function setType(DateTimeType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
