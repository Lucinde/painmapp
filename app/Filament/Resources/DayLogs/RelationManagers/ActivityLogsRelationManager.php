<?php

namespace App\Filament\Resources\DayLogs\RelationManagers;

use App\Enums\ActivityCategory;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'activityLogs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('daylog.activity_logs.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('activity_category')
                    ->label(__('daylog.activity_logs.category'))
                    ->options(ActivityCategory::class)
                    ->enum(ActivityCategory::class)
                    ->columnSpanFull()
                    ->required(),
                TimePicker::make('start_time')
                    ->label(__('daylog.start_time'))
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label(__('daylog.end_time'))
                    ->seconds(false)
                    ->required(),
                TextInput::make('intensity')
                    ->label(__('daylog.intensity'))
                    ->numeric(),
                TextInput::make('perceived_load')
                    ->label(__('daylog.activity_logs.perceived_load'))
                    ->numeric(),
                Textarea::make('notes')
                    ->label(__('daylog.notes'))
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('activity_category')
                    ->label(__('daylog.activity_logs.category'))
                    ->searchable(),
                TextColumn::make('start_time')
                    ->label(__('daylog.start_time'))
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label(__('daylog.end_time'))
                    ->time()
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label(__('daylog.duration_minutes'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('intensity')
                    ->label(__('daylog.intensity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('perceived_load')
                    ->label(__('daylog.activity_logs.perceived_load'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('notes')
                    ->label(__('daylog.notes')),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('daylog.activity_logs.create')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]))
            ->emptyStateHeading(__('daylog.activity_logs.empty_heading'))
            ->emptyStateDescription(__('daylog.activity_logs.empty_description'));
    }
}
