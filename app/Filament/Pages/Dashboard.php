<?php

namespace App\Filament\Pages;

use App\Filament\Resources\DayLogs\DayLogResource;
use App\Models\DayLog;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if (DayLogResource::isPhysioOrAdmin($user)) {
            return [];
        }

        return [
            Action::make('create_day_log')
                ->label(__('daylog.create'))
                ->url(DayLogResource::getUrl('create'))
                ->button()
                ->color('gray'),

            Action::make('today_day_log')
                ->label(__('daylog.today'))
                ->action(function () {
                    $log = DayLog::firstOrCreate([
                        'user_id' => auth()->id(),
                        'date' => today(),
                    ]);

                    return redirect(DayLogResource::getUrl('edit', ['record' => $log->id]));
                })
                ->button(),
        ];
    }
}
