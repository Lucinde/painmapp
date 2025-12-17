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
                    ->label(ucfirst(__('general.name'))),
                TextEntry::make('date')
                    ->label(ucfirst(__('general.date')))
                    ->date(),
                TextEntry::make('notes')
                    ->label(ucfirst(__('general.notes')))
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label(ucfirst(__('general.created_at')))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(ucfirst(__('general.updated_at')))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label(ucfirst(__('general.deleted_at')))
                    ->dateTime()
                    ->visible(fn (DayLog $record): bool => $record->trashed()),
            ]);
    }
}
