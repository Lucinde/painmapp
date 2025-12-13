<?php

namespace App\Policies;

use App\Models\DayLog;
use App\Models\User;

class DayLogPolicy
{
    /**
     * Determine whether the user can view any day logs.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('ViewAny:DayLog')) {
            return true;
        }

        return $user->can('View:DayLog');
    }

    /**
     * Determine whether the user can view a specific day log.
     */
    public function view(User $user, DayLog $dayLog): bool
    {
        // Admin
        if ($user->can('ViewAny:DayLog')) {
            return true;
        }

        if (! $user->can('View:DayLog')) {
            return false;
        }

        // Client: own log
        if ($dayLog->user_id === $user->id) {
            return true;
        }

        // Physio: logs from clients
        return $dayLog->user?->therapist_id === $user->id;
    }

    /**
     * Determine whether the user can create day logs.
     */
    public function create(User $user): bool
    {
        return $user->can('Create:DayLog');
    }

    /**
     * Determine whether the user can update the day log.
     */
    public function update(User $user, DayLog $dayLog): bool
    {
        // Admin
        if ($user->can('UpdateAny:DayLog')) {
            return true;
        }

        if (! $user->can('Update:DayLog')) {
            return false;
        }

        // Only owner can edit
        return $dayLog->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the day log.
     */
    public function delete(User $user, DayLog $dayLog): bool
    {
        // Admin
        if ($user->can('DeleteAny:DayLog')) {
            return true;
        }

        if (! $user->can('Delete:DayLog')) {
            return false;
        }

        // Only owner
        return $dayLog->user_id === $user->id;
    }

    public function restore(User $user, DayLog $dayLog): bool
    {
        return $user->can('UpdateAny:DayLog');
    }

    public function forceDelete(User $user, DayLog $dayLog): bool
    {
        return $user->can('DeleteAny:DayLog');
    }
}
