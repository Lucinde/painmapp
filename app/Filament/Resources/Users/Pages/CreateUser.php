<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

/**
 * @property User $record
 */
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $clientRole = Role::where('name', 'client')
            ->where('guard_name', 'web')
            ->first();

        if ($clientRole && $this->record->roles->isEmpty()) {
            $this->record->assignRole($clientRole);
        }
    }
}
