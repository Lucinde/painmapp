<?php

namespace App\Filament\Resources\DayLogs\Pages;

use App\Filament\Resources\DayLogs\DayLogResource;
use App\Filament\Widgets\PainActivityChart;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDayLogs extends ListRecords
{
    protected static string $resource = DayLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $userId = $this->getTableFilterState('user')['value'] ?? null;

        return [
            PainActivityChart::make([
                'userId' => $userId,
            ]),
        ];
    }
}
