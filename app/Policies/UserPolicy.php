<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin
        if ($user->can('view_any_user')) {
            return true;
        }

        // Fysio
        if ($user->can('view_user')) {
            return true;
        }

        // Client
        return false;
    }

    /**
     * Determine whether the user can view a single user model.
     */
    public function view(User $user, User $model): bool
    {
        // Admin
        if ($user->can('view_any_user')) {
            return true;
        }

        // Own profile
        if ($model->id === $user->id) {
            return $user->can('view_user');
        }

        // Fysio
        if ($user->can('view_user') && $model->therapist_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin & Fysio
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admin
        if ($user->can('update_any_user')) {
            return true;
        }

        // Own profile
        if ($model->id === $user->id) {
            return $user->can('update_user');
        }

        // Fysio: own clients
        if ($user->can('update_user') && $model->therapist_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Admin
        if ($user->can('delete_any_user')) {
            return true;
        }

        // Fysio: own clients
        if ($user->can('delete_user') && $model->therapist_id === $user->id) {
            return true;
        }

        return false;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can('update_any_user');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('delete_any_user');
    }
}
