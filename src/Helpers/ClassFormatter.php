<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Helpers;

final readonly class ClassFormatter
{
    public static function getModelNameFromTableName(string $tableName): string
    {
        return \str($tableName)
            ->singular()
            ->camel()
            ->ucfirst()
            ->toString();
    }

    public static function getRelatedModelNameFromFieldName(string $field): string
    {
        return \str($field)
            ->replace('_id', '')
            ->camel()
            ->singular()
            ->ucfirst()
            ->toString();
    }

    public static function getBelongsToMethodNameFromFieldName(string $field): string
    {
        return \str($field)
            ->replace('_id', '')
            ->camel()
            ->toString();
    }
}
