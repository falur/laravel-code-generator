<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns;

use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Traits\HasInMigration;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Traits\HasInModel;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Traits\HasInMoonshineResource;
use GianTiaga\CodeGenerator\Traits\HasComment;
use GianTiaga\CodeGenerator\Traits\HasDefaultValue;
use GianTiaga\CodeGenerator\Traits\HasFillable;
use GianTiaga\CodeGenerator\Traits\HasFilterable;
use GianTiaga\CodeGenerator\Traits\HasLabel;
use GianTiaga\CodeGenerator\Traits\HasName;
use GianTiaga\CodeGenerator\Traits\HasRequired;
use GianTiaga\CodeGenerator\Traits\HasSearchable;
use GianTiaga\CodeGenerator\Traits\HasSortable;
use GianTiaga\CodeGenerator\Traits\HasUnique;
use GianTiaga\CodeGenerator\Traits\Makeable;

abstract class AbstractColumn
{
    use Makeable;
    use HasName;
    use HasLabel;
    use HasRequired;
    use HasUnique;
    use HasDefaultValue;
    use HasComment;
    use HasFillable;
    use HasSortable;
    use HasSearchable;
    use HasInMigration;
    use HasInModel;
    use HasInMoonshineResource;
    use HasFilterable;

    protected function __construct(
        ?string $name = null,
        ?string $label = null,
    ) {
        if ($name) {
            $this->setName($name);
        }

        if ($label) {
            $this->setLabel($label);
        }
    }
}
