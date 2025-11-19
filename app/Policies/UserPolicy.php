<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view any user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->can('view any user')) {
            return true;
        }

        if ($user->can('view own client') && $model->therapist_id === $user->id) {
            return true;
        }

        if ($user->can('view own profile') && $model->id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('create any user')) {
            return true;
        }

        if ($user->can('create own client')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->can('edit any user')) {
            return true;
        }

        if ($user->can('edit own client') && $model->therapist_id === $user->id) {
            return true;
        }

        if ($user->can('edit own profile') && $model->id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->can('delete any user')) {
            return true;
        }

        if ($user->can('delete own client') && $model->therapist_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('edit any user');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('delete any user');
    }
}
