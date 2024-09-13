<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\FactoryPlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;

class FactoryBuilder extends AbstractBuilder
{
    protected function defaultDestination(): string
    {
        return database_path('factories');
    }

    protected function defaultFrom(): string
    {
        return 'gian-code-generator::factory';
    }
}
