<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\UserResource;
use App\Models\DayLog;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActiveClients extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return __('user.active_clients');
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->can('ViewClient:User');
    }

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
                CreateAction::make()
                    ->schema([
                            TextInput::make('name')
                                ->label(ucfirst(__('general.name')))
                                ->required(),
                            TextInput::make('email')
                                ->label(ucfirst(__('general.email')))
                                ->email()
                                ->required(),
                            TextInput::make('password')
                                ->label(ucfirst(__('general.password')))
                                ->password()
                                ->revealable()
                                ->copyable(copyMessage: __('general.copied'))
                                ->required(fn($livewire) => $livewire instanceof CreateUser)
                                ->dehydrated(fn ($state) => filled($state)),
                    ])
                    ->using(function (array $data) {
                        if (Auth::user()->can('view client log')) {
                            $data['therapist_id'] = Auth::id();
                        }

                        return User::create($data);
                    })
                    ->label(__('user.create_client')),
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
