<?php

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Fields\ID;
use GianTiaga\CodeGenerator\Columns\Fields\Text;
use GianTiaga\CodeGenerator\Columns\Fields\Timestamps;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineBuilder;
use Spatie\Permission\Models\Role;

return TableBuilder::make('roles', 'Роли')
    ->setModelBuilder(
        ModelBuilder::make()
            ->setExtends(new ClassNameDto(Role::class, 'SpatieRole'))
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

        BelongsToMany::make('permissions', 'Права')
            ->setInMigration(false)
            ->setInModel(false)
            ->required(),

        Timestamps::make(),
    ]);
