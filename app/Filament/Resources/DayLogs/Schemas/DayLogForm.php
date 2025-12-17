<?php

namespace App\Filament\Resources\DayLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DayLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(ucfirst(__('general.name')))
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->label(ucfirst(__('general.date')))
                    ->required(),
                Textarea::make('notes')
                    ->label(ucfirst(__('general.notes')))
                    ->columnSpanFull(),
            ]);
    }
}
