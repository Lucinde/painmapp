<?php

namespace App\Filament\Resources\DayLogs\Pages;

use App\Filament\Resources\DayLogs\DayLogResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDayLog extends CreateRecord
{
    protected static string $resource = DayLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
