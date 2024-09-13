<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\FactoryPlugin\Views;

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Views\ViewInterface;

class FactoryView implements ViewInterface
{
    public function __construct(
        protected TableBuilder $table,
    ) {
    }

    public function model(): string
    {
        return ClassFormatter::getModelNameFromTableName(
            $this->table->getName()
        );
    }
}
