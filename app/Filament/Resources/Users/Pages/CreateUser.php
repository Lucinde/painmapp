<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()->hasRole('fysio')) {
            $data['role'] = 'client';
            $data['therapist_id'] = auth()->id();
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var \App\Models\User $user */
        $user = $this->record;

        if (auth()->user()->hasRole('fysio')) {
            $user->assignRole('client'); // Add role to new user
        }
    }
}
