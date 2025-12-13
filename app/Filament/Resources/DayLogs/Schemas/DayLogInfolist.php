<?php

namespace App\Filament\Resources\DayLogs\Schemas;

use App\Models\DayLog;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DayLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (DayLog $record): bool => $record->trashed()),
            ]);
    }
}
