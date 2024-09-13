@php /** @var \GianTiaga\CodeGenerator\Plugins\FactoryPlugin\Views\FactoryView $view */ @endphp
{!! '<?php' !!}

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @@extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\{{ $view->model() }}>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }
}
