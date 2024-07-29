<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Traits\HasDefaultValue;
use GianTiaga\CodeGenerator\Traits\HasFillable;
use GianTiaga\CodeGenerator\Traits\HasFluent;
use GianTiaga\CodeGenerator\Traits\HasRequired;
use GianTiaga\CodeGenerator\Traits\HasSearchable;
use GianTiaga\CodeGenerator\Traits\HasSortable;
use GianTiaga\CodeGenerator\Traits\Makeable;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class MoonshineColumnBuilder
{
    use Makeable;
    use HasRequired;
    use HasSortable;
    use HasSearchable;
    use HasDefaultValue;
    use HasFluent;

    protected ?string $moonshineField = null;

    public static function makeFromColumn(AbstractColumn $column, string $moonshineField): static
    {
        return static::make()
            ->addFluentWhen(
                $column->isRequired(),
                new MethodDto('required')
            )
            ->addFluentWhen(
                $column->isSortable(),
                new MethodDto('sortable')
            )
            ->addFluentWhen(
                (bool)$column->getDefaultValue(),
                new MethodDto('default', [
                    ArgumentDto::any($column->getDefaultValue())
                ]),
            )
            ->setRequired($column->isRequired())
            ->setSortable($column->isSortable())
            ->setSearchable($column->isSearchable())
            ->setDefaultValue($column->getDefaultValue())
            ->setMoonshineField($moonshineField);
    }

    public function getMoonshineField(): ?string
    {
        return $this->moonshineField;
    }

    public function setMoonshineField(?string $moonshineField): static
    {
        $this->moonshineField = $moonshineField;

        return $this;
    }
}
