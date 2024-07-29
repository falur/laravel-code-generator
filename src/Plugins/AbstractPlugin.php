<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins;

use GianTiaga\CodeGenerator\Builders\CodeGenerator;

abstract class AbstractPlugin implements PluginInterface
{
    protected ?CodeGenerator $codeGenerator = null;

    public function register(CodeGenerator $codeGenerator): void
    {
        $this->codeGenerator = $codeGenerator;
    }

    abstract public function generate(): void;
}
