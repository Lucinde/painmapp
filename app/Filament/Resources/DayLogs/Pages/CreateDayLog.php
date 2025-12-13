<?php

namespace App\Filament\Resources\DayLogs\Pages;

use App\Filament\Resources\DayLogs\DayLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDayLog extends CreateRecord
{
    protected static string $resource = DayLogResource::class;
}
