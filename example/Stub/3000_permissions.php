<?php

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Fields\ID;
use GianTiaga\CodeGenerator\Columns\Fields\Slug;
use GianTiaga\CodeGenerator\Columns\Fields\Text;
use GianTiaga\CodeGenerator\Columns\Fields\Timestamps;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineBuilder;
use Spatie\Permission\Models\Permission;

return TableBuilder::make('permissions', 'Права')
    ->setModelBuilder(
        ModelBuilder::make()
            ->setExtends(new ClassNameDto(Permission::class, 'SpatiePermission'))
    )
    ->setMoonshineBuilder(
        MoonshineBuilder::make(),
    )
    ->setColumns([
        ID::make(),

        Text::make('display_name', 'Название')
            ->required(),

        Text::make('name', 'Служебное название')
            ->required(),

        Timestamps::make(),
    ]);
