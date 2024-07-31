<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Helpers;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Columns\Fields\Boolean;
use GianTiaga\CodeGenerator\Columns\Fields\Color;
use GianTiaga\CodeGenerator\Columns\Fields\DateTime;
use GianTiaga\CodeGenerator\Columns\Fields\Email;
use GianTiaga\CodeGenerator\Columns\Fields\File;
use GianTiaga\CodeGenerator\Columns\Fields\Number;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsTo;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Columns\Relations\HasMany;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;

final readonly class RendererHelper
{
    /**
     * @param  MethodDto  $action
     * @param  MethodDto[]  $fluent
     * @return void
     */
    public static function renderCallMethod(
        string $object,
        MethodDto $method,
        array $fluent = [],
        string $callKind = '->',
        string $finishSymbol = ';',
    ): string {
        return sprintf("%s{$callKind}%s(%s)%s".$finishSymbol,
            $object,
            $method->name,
            self::renderFunctionArguments($method->args),
            self::renderFluent($fluent),
        );
    }

    /**
     * @param  ?ArgumentDto[]  $args
     */
    public static function renderFunctionArguments(?array $args): string
    {
        if (! $args) {
            return '';
        }

        $result = [];
        foreach ($args as $arg) {
            if (! $arg) {
                continue;
            }
            $result[] = $arg->value;
        }

        return implode(', ', $result);
    }

    /**
     * @param  MethodDto[]  $fluents
     */
    public static function renderFluent(array $fluents): string
    {
        $result = '';
        foreach ($fluents as $fluent) {
            $result .= sprintf("\n->%s(%s)",
                $fluent->name,
                self::renderFunctionArguments($fluent->args),
            );
        }

        return $result;
    }

    /**
     * @param  mixed[]  $array
     */
    public function renderList(array $array, string|int|null $key = null): string
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $key ? data_get($item, $key) : $item;
        }

        return implode(",\n", $result).',';
    }

    public static function renderRulesForColumn(AbstractColumn $column): string
    {
        if (! $column->getDatabaseColumn()) {
            return '';
        }

        if ($column instanceof HasMany) {
            return '';
        }

        if ($column instanceof BelongsToMany) {
            return '';
        }

        $result = "'{$column->getDatabaseColumn()}' => [";
        if ($column->isRequired() && ! ($column instanceof File || $column instanceof BelongsToMany || $column instanceof HasMany)) {
            $result .= "'required', ";
        }
        if ($column->isUnique()) {
            $result .= "'unique', ";
        }
        if ($column instanceof Boolean) {
            $result .= "'boolean', ";
        }
        if ($column instanceof Number || $column instanceof BelongsTo) {
            $result .= "'integer', ";
        }
        if ($column instanceof DateTime) {
            $result .= "'date', ";
        }
        if ($column instanceof Email) {
            $result .= "'email', ";
        }
        if ($column instanceof Color) {
            $result .= "'hex_color', ";
        }
        $result = trim($result);
        $result = trim($result, ',');
        $result .= ']';

        return $result;
    }
}
