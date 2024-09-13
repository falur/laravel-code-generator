<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\FactoryPlugin;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\AbstractPlugin;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views\MoonshineView;
use GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Views\PolicyView;
use GianTiaga\CodeGenerator\Renderers\Renderer;

class FactoryPlugin extends AbstractPlugin
{
    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        foreach ($this->codeGenerator->getTables() as $table) {
            $renderer = new Renderer(
                new PolicyView($table),
                $table->getFactoryBuilder(),
            );

            $renderer->copyRendered(
                $this->getFactoryFileName(
                    $table,
                ),
            );
        }
    }

    protected function getFactoryFileName(TableBuilder $table): string
    {
        return str(ClassFormatter::getModelNameFromTableName($table->getName()))
            ->append('Factory.php')
            ->toString();
    }
}
