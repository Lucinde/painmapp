<?php

namespace App\Filament\Resources\DayLogs\Pages;

use App\Filament\Resources\DayLogs\DayLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDayLog extends ViewRecord
{
    protected static string $resource = DayLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
