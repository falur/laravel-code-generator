<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;

class MoonshineBuilder extends AbstractBuilder
{
    protected function defaultDestination(): string
    {
        return app_path('MoonShine/Resources');
    }

    protected function defaultFrom(): string
    {
        return 'gian-code-generator::moonshine-resource';
    }
}
