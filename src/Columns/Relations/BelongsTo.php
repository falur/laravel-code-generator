<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use GianTiaga\CodeGenerator\Types\ArgumentTypes\Str;

class BelongsTo extends AbstractRelation
{
    public function getName(): ?string
    {
        if ($this->name) {
            return \str($this->name)
                ->snake()
                ->append('_id')
                ->toString();
        }

        return null;
    }
}
