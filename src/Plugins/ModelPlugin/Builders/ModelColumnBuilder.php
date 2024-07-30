<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Traits\HasCast;
use GianTiaga\CodeGenerator\Traits\HasEventAfter;
use GianTiaga\CodeGenerator\Traits\HasEventsBefore;
use GianTiaga\CodeGenerator\Traits\HasFillable;
use GianTiaga\CodeGenerator\Traits\Makeable;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class ModelColumnBuilder
{
    use HasCast;
    use HasEventAfter;
    use HasEventsBefore;
    use HasFillable;
    use Makeable;

    public static function makeFromColumn(AbstractColumn $column): static
    {
        return static::make()
            ->setFillable($column->isFillable())
            ->setFillableColumn(
                $column->getName()
                    ? (string) new Str($column->getName())
                    : null
            );
    }
}
