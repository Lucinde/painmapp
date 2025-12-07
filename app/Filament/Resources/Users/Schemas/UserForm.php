<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\Pages\CreateUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->copyable(__('general.copied'))
                    ->required(fn($livewire) => $livewire instanceof CreateUser)
                    ->dehydrated(fn ($state) => filled($state)),
                Select::make('therapist_id')
                    ->label(ucfirst(__('user.physio')))
                    ->relationship('therapist', 'name', modifyQueryUsing: fn ($query) => $query->whereHas('roles', fn($q) => $q->where('name', 'fysio')))
                    ->default(fn() => auth()->user()->hasRole('fysio') ? auth()->id() : null)
                    ->disabled(fn() => auth()->user()->hasRole('fysio')),
            ]);
    }
}
