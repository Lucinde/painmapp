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
        return $user->can('ViewAny:User');
    }

    /**
     * Determine whether the user can view a single user model.
     */
    public function view(User $user, User $model): bool
    {
        // Admin
        if ($user->can('ViewAny:User')) {
            return true;
        }

        // Own profile
        if ($model->id === $user->id && $user->can('View:User')) {
            return true;
        }

        // Physio
        if ($model->therapist_id === $user->id && $user->can('View:User')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin
        if ($user->can('CreateAny:User')) {
            return true;
        }

        // Physio
        return $user->can('Create:User');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admin
        if ($user->can('UpdateAny:User')) {
            return true;
        }

        // Own profile
        if ($model->id === $user->id && $user->can('Update:User')) {
            return true;
        }

        // Physio: own clients
        if ($model->therapist_id === $user->id && $user->can('Update:User')) {
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
        if ($user->can('DeleteAny:User')) {
            return true;
        }

        // Physio: own clients
        if ($user->can('Delete:User') && $model->therapist_id === $user->id) {
            return true;
        }

        return false;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can('UpdateAny:User');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('DeleteAny:User');
    }
}
