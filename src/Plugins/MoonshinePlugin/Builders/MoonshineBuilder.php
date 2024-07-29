<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Traits\HasExtends;
use GianTiaga\CodeGenerator\Traits\HasImplements;
use GianTiaga\CodeGenerator\Traits\HasUses;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoonshineBuilder extends AbstractBuilder
{
    /**
     * @return string
     */
    protected function defaultDestination(): string
    {
        return app_path('MoonShine/Resources');
    }

    /**
     * @return string
     */
    protected function defaultFrom(): string
    {
        return 'gian-code-generator::moonshine-resource';
    }
}
