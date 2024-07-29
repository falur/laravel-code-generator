<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Traits\HasMigrationBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Traits\HasModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Traits\HasMoonshineBuilder;
use GianTiaga\CodeGenerator\Traits\HasColumns;
use GianTiaga\CodeGenerator\Traits\HasLabel;
use GianTiaga\CodeGenerator\Traits\HasName;
use GianTiaga\CodeGenerator\Traits\Makeable;
use Illuminate\Support\Str;

class TableBuilder
{
    use Makeable;
    use HasName;
    use HasLabel;
    use HasColumns;
    use HasMigrationBuilder;
    use HasModelBuilder;
    use HasMoonshineBuilder;

    /**
     * @param string $name
     * @param ?string $label
     */
    protected function __construct(
        string $name,
        string $label = null,
    ) {
        $this->setName($name);
        $this->setLabel($label);
    }

    public function getLabel(): string
    {
        return $this->label ?? ClassFormatter::getClassNameFromTableName($this->getName());
    }
}
