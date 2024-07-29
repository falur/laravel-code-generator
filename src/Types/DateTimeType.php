<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types;

enum DateTimeType
{
    case timestamp;
    case date;
    case datetime;
    case dateTimeTz;
    case timestampTz;
}
