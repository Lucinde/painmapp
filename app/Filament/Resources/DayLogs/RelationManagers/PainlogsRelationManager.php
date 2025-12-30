<?php

namespace App\Filament\Resources\DayLogs\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PainlogsRelationManager extends RelationManager
{
    protected static string $relationship = 'painlogs';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('daylog.pain_logs.title');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('start_time')
                    ->label(__('daylog.pain_logs.start_time'))
                    ->dateTime('H:i')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label(__('daylog.pain_logs.end_time'))
                    ->dateTime('H:i')
                    ->sortable(),
                TextColumn::make('location')
                    ->label(__('daylog.pain_logs.location'))
                    ->badge()
                    ->colors(['primary']),
                TextColumn::make('intensity')
                    ->label(__('daylog.pain_logs.intensity'))
                    ->sortable(),
                TextColumn::make('notes')
                    ->label(__('daylog.pain_logs.notes'))
                    ->limit(50),
            ])
            ->emptyStateHeading(__('daylog.pain_logs.empty_heading'))
            ->emptyStateDescription(__('daylog.pain_logs.empty_description'));
    }
}
