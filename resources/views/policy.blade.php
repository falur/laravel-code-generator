@php /** @var \GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Views\PolicyView $view */ @endphp
{!! '<?php' !!}

namespace App\Policies;

use App\Models\{!! $view->model() !!};
use App\Models\User;
use Illuminate\Auth\Access\Response;

class {!! $view->model() !!}Policy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, {!! $view->model() !!} $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, {!! $view->model() !!} $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, {!! $view->model() !!} $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, {!! $view->model() !!} $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, {!! $view->model() !!} $model): bool
    {
        //
    }
}
