<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('therapist.name')
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

                if ($user->can('ViewAssigned:User')) {
                    $query->where('therapist_id', $user->id)->orWhere('id', $user->id);
                }
            });
    }
}
