<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\PolicyPlugin;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\AbstractPlugin;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views\MoonshineView;
use GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Views\PolicyView;
use GianTiaga\CodeGenerator\Renderers\Renderer;

class PolicyPlugin extends AbstractPlugin
{
    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        foreach ($this->codeGenerator->getTables() as $table) {
            $policyBuilder = $table->getPolicyBuilder();

            if (!$policyBuilder) {
                continue;
            }

            $renderer = new Renderer(
                new PolicyView($table),
                $table->getPolicyBuilder(),
            );

            $renderer->copyRendered(
                $this->getPolicyFileName(
                    $table,
                ),
            );
        }
    }

    protected function getPolicyFileName(TableBuilder $table): string
    {
        return str(ClassFormatter::getModelNameFromTableName($table->getName()))
            ->append('Policy.php')
            ->toString();
    }
}
