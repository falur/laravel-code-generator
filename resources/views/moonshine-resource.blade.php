@php /** @var \GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views\MoonshineView $view */ @endphp
{!! '<?php' !!}

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\{!! $view->model() !!};
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
{!! $view->imports() !!}

/**
 * @@extends ModelResource<{!! $view->model() !!}>
 */
class {!! $view->model() !!}Resource extends ModelResource
{
    protected string $model = {!! $view->model() !!}::class;

    protected string $title = '{!! $view->label() !!}';

    protected string $column = 'id';

    protected bool $withPolicy = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            {!! $view->indexFields() !!}
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                {!! $view->formFields() !!}
            ])
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function detailFields(): iterable
    {
        return $this->formFields();
    }

    /**
     * @param {!! $view->model() !!} $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            {!! $view->rules() !!}
        ];
    }

    /**
     * @return string[]
     */
    public function search(): array
    {
        return [
            {!! $view->searches() !!}
        ];
    }

    /**
     * @return list<FieldContract>
     */
    public function filters(): array
    {
        return [
            {!! $view->filters() !!}
        ];
    }
}
