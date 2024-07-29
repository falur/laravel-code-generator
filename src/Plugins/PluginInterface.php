<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins;

use GianTiaga\CodeGenerator\Builders\CodeGenerator;

interface PluginInterface
{
    public function register(CodeGenerator $codeGenerator): void;
    public function generate(): void;
}
