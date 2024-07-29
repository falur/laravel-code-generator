<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;
use GianTiaga\CodeGenerator\Traits\HasIndexes;
use GianTiaga\CodeGenerator\Traits\HasUniques;

class MigrationBuilder extends AbstractBuilder
{
    use HasIndexes;
    use HasUniques;

    /**
     * @return string
     */
    protected function defaultDestination(): string
    {
        return database_path('migrations');
    }

    /**
     * @return string
     */
    protected function defaultFrom(): string
    {
        return 'gian-code-generator::migration';
    }
}
