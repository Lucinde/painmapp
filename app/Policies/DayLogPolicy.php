<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DayLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class DayLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $user): bool
    {
        return
            $user->can('ViewAny:DayLog') ||
            $user->can('ViewClient:DayLog') ||
            $user->can('ViewOwn:DayLog');
    }

    public function view(AuthUser $user, DayLog $dayLog): bool
    {
        if ($user->can('ViewAny:DayLog')) {
            return true;
        }

        if ($user->can('ViewClient:DayLog')) {
            return $dayLog->user?->therapist_id === $user->id;
        }

        if ($user->can('ViewOwn:DayLog')) {
            return $dayLog->user_id === $user->id;
        }

        return false;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DayLog');
    }

    public function update(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('Update:DayLog');
    }

    public function delete(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('Delete:DayLog');
    }

    public function restore(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('Restore:DayLog');
    }

    public function forceDelete(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('ForceDelete:DayLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DayLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DayLog');
    }

    public function replicate(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('Replicate:DayLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DayLog');
    }

    public function viewOwn(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('ViewOwn:DayLog');
    }

    public function viewClient(AuthUser $authUser, DayLog $dayLog): bool
    {
        return $authUser->can('ViewClient:DayLog');
    }

}
