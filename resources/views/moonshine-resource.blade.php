@php /** @var \GianTiaga\CodeGenerator\Plugins\MoonshinePlugin\Views\MoonshineView $view */ @endphp
{!! '<?php' !!}

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;
use App\Models\{!! $view->model() !!};
{!! $view->imports() !!}

/**
 * @@extends ModelResource<{!! $view->model() !!}>
 */
class {!! $view->model() !!}Resource extends ModelResource
{
    protected string $model = {!! $view->model() !!}::class;

    protected string $title = '{!! $view->label() !!}';

    protected string $column = 'id';

    /**
     * @return list<Field>
     */
    public function indexFields(): array
    {
        return [
            {!! $view->fields() !!}
        ];
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function formFields(): array
    {
        return [
            Block::make([
                {!! $view->fields() !!}
            ]),
        ];
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function detailFields(): array
    {
        return $this->formFields();
    }

    /**
     * @param {!! $view->model() !!} $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
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
}
