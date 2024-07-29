<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Helpers;

final class MigrationCounter
{
    protected static int $i = 0;

    public static function next(): int
    {
        $current = self::current();
        self::increment();

        return $current;
    }

    public static function current(): int
    {
        return self::$i;
    }

    public static function increment(): void
    {
        self::$i++;
    }
}
