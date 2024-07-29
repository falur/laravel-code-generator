<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Traits;

trait HasInMigration
{
    protected bool $inMigration = true;

    public function isInMigration(): bool
    {
        return $this->inMigration;
    }

    public function setInMigration(bool $inMigration): static
    {
        $this->inMigration = $inMigration;

        return $this;
    }
}
