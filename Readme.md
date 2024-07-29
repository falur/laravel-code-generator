[EN Version](EN.md)

# Мотивация
На гитхабе есть несколько хороших генераторов кода, но все они не устроили по нескольким причинам, вот что есть в этом пакете чего нет в других:
1. 1 раз описываем схему из которой формируются разные сущности
2. Расширяемость плагинами, можно написать свои плагины и из той же схемы генерировать ваши данные
3. Схема описывается через вызовы нужных классов, в отличии от json вам не нужно помнить какие возможности есть
4. Для генераторов используются привычные blade шаблоны, что даёт большию гибкость чем привычные stub файлы

# Установка
`composer require gian_tiaga/code-generator` 

# Как использовать
1. Создать директорию с файлами описывающие ваши сущности

Пример:
`app/CodeGenerator/1000_users.php`
```php
<?php

use GianTiaga\CodeGenerator\Builders\TableBuilder;
use GianTiaga\CodeGenerator\Columns\Fields\DateTime;
use GianTiaga\CodeGenerator\Columns\Fields\Email;
use GianTiaga\CodeGenerator\Columns\Fields\ID;
use GianTiaga\CodeGenerator\Columns\Fields\Password;
use GianTiaga\CodeGenerator\Columns\Fields\Phone;
use GianTiaga\CodeGenerator\Columns\Fields\Text;
use GianTiaga\CodeGenerator\Columns\Fields\Timestamps;
use GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Dto\IndexDto;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders\MigrationBuilder;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders\ModelBuilder;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Builders\MoonshineBuilder;
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
        ID::make()
            ->sortable(),

        Text::make('first_name', 'Имя')
            ->filterable()
            ->searchable()
            ->sortable()
            ->required(),

        Text::make('last_name', 'Фамилия')
            ->filterable()
            ->searchable()
            ->sortable()
            ->searchable(),

        Email::make('email', 'Email')
            ->filterable()
            ->searchable()
            ->sortable()
            ->required()
            ->unique(),

        Phone::make('phone', 'Телефон')
            ->filterable()
            ->searchable()
            ->sortable()
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
            ->filterable()
            ->setInMigration(false)
            ->setInModel(false)
            ->required(),

        Timestamps::make(),
    ]);

```

2. Создать консольную команду для выполнения генерации

Пример 
```php
<?php

namespace App\Console\Commands;

use GianTiaga\CodeGenerator\Builders\CodeGenerator;
use GianTiaga\CodeGenerator\Plugins\MigrationPlugin\MigrationPlugin;
use GianTiaga\CodeGenerator\Plugins\ModelPlugin\ModelPlugin;
use GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\MoonshinePlugin;
use Illuminate\Console\Command;

class GenerateCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Code Generator';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle(): void
    {
        CodeGenerator::make()
            ->registerPlugins([
                new MigrationPlugin(),
                new ModelPlugin(),
                new MoonshinePlugin(),
            ])
            ->setTablesFromDir(app_path('CodeGenerator'))
            ->generate();

        exec('./vendor/bin/pint database/migrations');
        exec('./vendor/bin/pint app/Models');
        exec('./vendor/bin/pint app/MoonShine');
    }
}

```

В результате этого кода мы получаем 3 файла
1. Миграция
2. Модель
3. Moonshine Resource

# TODO

## TODO Command
- [ ] Create file of scheme

## TODO Fields
- [ ] Enum
- [ ] Select
- [ ] Default Image for Moonshine
- [ ] Default File for Moonshine
- [ ] Morph Fields

## TODO Plugins

- [ ] Policies
- [ ] Factories
- [ ] Api Resources
- [ ] Request
- [ ] CRUD Actions with CRUD DTO
- [ ] CRUD Controllers
