@php
    /** @var \GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Views\MigrationsView $view */
    $indexes = $view->indexes();
    $uniques =  $view->uniques();

    if ($indexes) {
        $indexes = "\n\n" . $indexes;
    }

     if ($uniques) {
        $uniques = $indexes ? ("\n" . $uniques) : ("\n\n" . $uniques);
    }
@endphp
{!! '<?php' !!}

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('{{ $view->tableName() }}', function (Blueprint $table) {
            {!! $view->columns() !!} {!! $indexes !!} {!! $uniques !!}
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{{ $view->tableName() }}');
    }
};
