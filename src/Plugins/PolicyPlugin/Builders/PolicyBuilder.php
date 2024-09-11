<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;

class PolicyBuilder extends AbstractBuilder
{
    protected function defaultDestination(): string
    {
        return app_path('Policies');
    }

    protected function defaultFrom(): string
    {
        return 'gian-code-generator::policy';
    }
}
