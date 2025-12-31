<?php

namespace App\Filament\Resources\DayLogs\Schemas;

use App\Models\DayLog;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
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
                RepeatableEntry::make('painlogs')
                    ->label(ucfirst(__('daylog.pain_logs.title')))
                    ->table([
                        TableColumn::make(__('daylog.pain_logs.start_time')),
                        TableColumn::make(__('daylog.pain_logs.end_time')),
                        TableColumn::make(__('daylog.pain_logs.duration_minutes')),
                        TableColumn::make(__('daylog.pain_logs.intensity')),
                        TableColumn::make(__('daylog.pain_logs.location')),
                        TableColumn::make(__('daylog.pain_logs.notes')),
                    ])
                    ->schema([
                        TextEntry::make('start_time')
                            ->dateTime('H:i'),
                        TextEntry::make('end_time')
                            ->dateTime('H:i'),
                        TextEntry::make('duration_minutes'),
                        TextEntry::make('intensity'),
                        TextEntry::make('location'),
                        TextEntry::make('notes'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
