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
    protected $description = 'Command description';

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
            ->setTablesFromDir(app_path('Stub'))
            ->generate();

        exec('./vendor/bin/pint database/migrations');
        exec('./vendor/bin/pint app/Models');
        exec('./vendor/bin/pint app/MoonShine');
    }
}
