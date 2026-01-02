<?php

namespace App\Filament\Resources\DayLogs\RelationManagers;

use App\Enums\PainLocation;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PainlogsRelationManager extends RelationManager
{
    protected static string $relationship = 'painLogs';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('daylog.pain_logs.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
                TimePicker::make('start_time')
                    ->label(__('daylog.pain_logs.start_time'))
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label(__('daylog.pain_logs.end_time'))
                    ->seconds(false)
                    ->required(),
                Select::make('location')
                    ->label(__('daylog.pain_logs.location'))
                    ->options(PainLocation::class)
                    ->multiple()
                    ->required(),
                TextInput::make('intensity')
                    ->label(__('daylog.pain_logs.intensity'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required(),
                TextInput::make('notes')
                    ->label(__('daylog.pain_logs.notes'))
                    ->maxLength(500),
            ]);
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
                TextColumn::make('duration_minutes')
                    ->label(__('daylog.pain_logs.duration_minutes')),
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
            ->headerActions([
                CreateAction::make()
                    ->label(__('daylog.pain_logs.create')),
            ])
            ->emptyStateHeading(__('daylog.pain_logs.empty_heading'))
            ->emptyStateDescription(__('daylog.pain_logs.empty_description'));
    }
}
