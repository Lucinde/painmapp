<?php

namespace App\Filament\Resources\DayLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class DayLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label(ucfirst(__('general.date')))
                    ->required(),
                Textarea::make('notes')
                    ->label(ucfirst(__('general.notes')))
                    ->columnSpanFull(),
            ]);
    }
}
