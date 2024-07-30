<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders;

use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Traits\HasMigrationBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Traits\HasModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Traits\HasMoonshineBuilder;
use GianTiaga\CodeGenerator\Traits\HasColumns;
use GianTiaga\CodeGenerator\Traits\HasLabel;
use GianTiaga\CodeGenerator\Traits\HasName;
use GianTiaga\CodeGenerator\Traits\Makeable;

class TableBuilder
{
    use HasColumns;
    use HasLabel;
    use HasMigrationBuilder;
    use HasModelBuilder;
    use HasMoonshineBuilder;
    use HasName;
    use Makeable;

    protected function __construct(
        string $name,
        ?string $label = null,
    ) {
        $this->setName($name);
        $this->setLabel($label);
    }

    public function getLabel(): string
    {
        if ($this->label) {
            return $this->label;
        }

        if ($this->getName()) {
            return ClassFormatter::getClassNameFromTableName($this->getName());
        }

        return '';
    }
}
