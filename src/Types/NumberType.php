<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Types;

enum NumberType
{
    case unsignedBigInteger;
    case unsignedInteger;
    case unsignedSmallInteger;
    case unsignedMediumInteger;
    case unsignedTinyInteger;
    case bigInteger;
    case integer;
    case smallInteger;
    case mediumInteger;
    case tinyInteger;
    case float;
    case decimal;
}
