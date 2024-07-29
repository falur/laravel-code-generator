@php /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */ @endphp
{!! '<?php' !!}

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
{!! $view->imports() !!}

class {!! $view->className() !!} {!! $view->extends() !!} {!! $view->implements() !!}
{
    {!! $view->uses() !!}

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        {!! $view->fillable() !!}
    ];

    /**
     * @return array<array-key, mixed>
     */
    protected function casts(): array
    {
        return [
            {!! $view->casts() !!}
        ];
    }

    @foreach($view->getColumns() as $column)
        @includeWhen($column->column instanceof \GianTiaga\CodeGenerator\Columns\Relations\BelongsTo, 'gian-code-generator::relations.belongsTo', ['view' => $view, 'column' => $column])

        @includeWhen($column->column instanceof \GianTiaga\CodeGenerator\Columns\Relations\BelongsToMany, 'gian-code-generator::relations.belongsToMany', ['view' => $view, 'column' => $column])

        @includeWhen($column->column instanceof \GianTiaga\CodeGenerator\Columns\Relations\HasMany, 'gian-code-generator::relations.HasMany', ['view' => $view, 'column' => $column])
    @endforeach
}
