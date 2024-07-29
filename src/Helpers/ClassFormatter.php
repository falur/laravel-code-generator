<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Helpers;

final readonly class ClassFormatter
{
    public static function getClassNameFromTableName(string $tableName): string
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

    public static function getShortRelationNameFromFieldName(string $field): string
    {
        return \str($field)
            ->replace('_id', '')
            ->camel()
            ->ucfirst()
            ->append('::class')
            ->toString();
    }

    public static function getFullRelationNameFromFieldName(string $field): string
    {
        return \str($field)
            ->replace('_id', '')
            ->camel()
            ->ucfirst()
            ->prepend('App\\Models\\')
            ->append('::class')
            ->toString();
    }
}
