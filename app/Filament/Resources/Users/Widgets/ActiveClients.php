<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\DayLog;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActiveClients extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder =>
            User::with('latestDaylog')
                ->orderByLatestDaylog()
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('latestDaylog.date')
                    ->label(__('user.latest_daylog'))
                    ->dateTime('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('view_daylogs')
                    ->label('Bekijk daglogs')
                    ->icon('heroicon-o-calendar-days')
                    ->url(fn (User $record) => route('filament.dashboard.resources.day-logs.index', [
                        'filters[user][value]' => $record->id
                    ]))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->can('ViewAny:User')) {
                    // Super admin: alles zien, geen filter
                    return $query;
                }

                if ($user->can('ViewClient:User')) {
                    // Fysio: alleen eigen clients
                    $query->where('therapist_id', $user->id);
                } elseif ($user->can('ViewOwn:User')) {
                    // Client: alleen zichzelf
                    $query->where('id', $user->id);
                } else {
                    // Geen permissie: niks tonen
                    $query->whereRaw('1 = 0');
                }

                return $query;
            });
    }
}
