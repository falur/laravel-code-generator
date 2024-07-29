<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Traits;

use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationBuilder;

trait HasMigrationBuilder
{
    protected ?MigrationBuilder $migrationBuilder = null;

    public function getMigrationBuilder(): ?MigrationBuilder
    {
        return $this->migrationBuilder;
    }

    public function setMigrationBuilder(?MigrationBuilder $migrationBuilder): static
    {
        $this->migrationBuilder = $migrationBuilder;

        return $this;
    }
}
