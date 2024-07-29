<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Helpers;

final readonly class ClassFormatter
{
    public static function getClassNameFromTableName(string $tableName): string
    {
        return (string) \str($tableName)
            ->singular()
            ->camel()
            ->ucfirst();
    }

    public static function getBelongsToClassNameFromFieldName(string $field): string
    {
        return (string) \str($field)
            ->replace('_id', '')
            ->camel()
            ->ucfirst();
    }

    public static function getBelongsToMethodNameFromFieldName(string $field): string
    {
        return (string) \str($field)
            ->replace('_id', '')
            ->camel();
    }

    public static function getFullRelationNameFromFieldName(string $field): string
    {
        return (string) \str($field)
            ->replace('_id', '')
            ->camel()
            ->ucfirst()
            ->prepend('App\\Models\\')
            ->append('::class');
    }
}
