<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Fields;

class File extends AbstractField
{
    protected bool $inMigration = false;

    protected bool $inModel = false;
}
