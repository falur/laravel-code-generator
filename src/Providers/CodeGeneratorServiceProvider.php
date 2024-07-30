<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Providers;

use Illuminate\Support\ServiceProvider;

class CodeGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(
            __DIR__.'/../../resources/views',
            'gian-code-generator'
        );
    }
}
