<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('therapist.name')
                    ->hidden(fn() => auth()->user()->hasRole('fysio'))
                    ->label(ucfirst(__('user.physio')))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(ucfirst(__('general.name')))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(ucfirst(__('general.email')))
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->label(ucfirst(__('user.email_verified_at')))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(ucfirst(__('general.created_at')))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(ucfirst(__('general.updated_at')))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
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
