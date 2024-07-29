<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

use GianTiaga\CodeGenerator\Builders\CodeGenerator;
use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Dto\IndexDto;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationColumnBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelColumnBuilder;
use Illuminate\Support\Str;

class BelongsToMany extends AbstractRelation
{
}
