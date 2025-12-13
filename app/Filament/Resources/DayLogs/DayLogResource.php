<?php

namespace App\Filament\Resources\DayLogs;

use App\Filament\Resources\DayLogs\Pages\CreateDayLog;
use App\Filament\Resources\DayLogs\Pages\EditDayLog;
use App\Filament\Resources\DayLogs\Pages\ListDayLogs;
use App\Filament\Resources\DayLogs\Pages\ViewDayLog;
use App\Filament\Resources\DayLogs\Schemas\DayLogForm;
use App\Filament\Resources\DayLogs\Schemas\DayLogInfolist;
use App\Filament\Resources\DayLogs\Tables\DayLogsTable;
use App\Models\DayLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DayLogResource extends Resource
{
    protected static ?string $model = DayLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DayLog';

    public static function form(Schema $schema): Schema
    {
        return DayLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DayLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DayLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDayLogs::route('/'),
            'create' => CreateDayLog::route('/create'),
            'view' => ViewDayLog::route('/{record}'),
            'edit' => EditDayLog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
