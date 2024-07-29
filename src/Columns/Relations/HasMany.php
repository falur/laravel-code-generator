<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;

class HasMany extends AbstractRelation
{
    public function defaultMigrationColumnBuilder(): ?\Closure
    {
        return null;
    }

    public function defaultModelColumnBuilder(): ?\Closure
    {
        return fn () => ModelColumnBuilder::make()
            ->setFillable(false);
    }
}
