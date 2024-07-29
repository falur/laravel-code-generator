<?php

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Fields\DateTime;
use GianTiaga\CodeGenerator\Columns\Fields\Email;
use GianTiaga\CodeGenerator\Columns\Fields\ID;
use GianTiaga\CodeGenerator\Columns\Fields\Password;
use GianTiaga\CodeGenerator\Columns\Fields\Phone;
use GianTiaga\CodeGenerator\Columns\Fields\Text;
use GianTiaga\CodeGenerator\Columns\Fields\Timestamps;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsTo;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Columns\Relations\HasMany;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Dto\IndexDto;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

return TableBuilder::make('users', 'Пользователи')
    ->setMigrationBuilder(
        MigrationBuilder::make()
            ->addToUniques(new IndexDto(['first_name']))
            ->addIndex(new IndexDto(['last_name']))
    )
    ->setModelBuilder(
        ModelBuilder::make()
            ->setExtends(new ClassNameDto(
                \Illuminate\Foundation\Auth\User::class,
                'Authenticatable'
            ))
            ->addImplement(new ClassNameDto(HasMedia::class))
            ->addUse(new ClassNameDto(HasRoles::class))
            ->addUse(new ClassNameDto(InteractsWithMedia::class))
            ->addUse(new ClassNameDto(Notifiable::class))
    )
    ->setMoonshineBuilder(
        MoonshineBuilder::make(),
    )
    ->setColumns([
        ID::make(),

        Text::make('first_name', 'Имя')
            ->searchable()
            ->required(),

        Text::make('last_name', 'Фамилия')
            ->searchable(),

        Email::make('email', 'Email')
            ->searchable()
            ->required()
            ->unique(),

        Phone::make('phone', 'Телефон')
            ->searchable()
            ->required()
            ->unique()
            ->setComment('Уже отформатированный'),

        Password::make('password', 'Пароль')
            ->required(),

        Text::make('remember_token')
            ->setInMoonshineResource(false),

        DateTime::make('email_verified_at')
            ->setInMoonshineResource(false),

        BelongsToMany::make('roles', 'Роли')
            ->setInMigration(false)
            ->setInModel(false)
            ->required(),

        Timestamps::make(),
    ]);
