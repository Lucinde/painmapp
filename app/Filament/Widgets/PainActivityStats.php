<?php

namespace App\Filament\Widgets;

use App\Models\DayLog;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PainActivityStats extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'Statistieken';

    protected function getStats(): array
    {
        $startDate = now()->subDays(7);
        $endDate = now();

        $logs = DayLog::with(['activityLogs', 'painLogs'])
            ->where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalActivity = $logs->sum(function($log) {
            return $log->activityLogs->sum('duration_minutes') ?? 0;
        });

        $totalPain = $logs->sum(function($log) {
            return $log->painLogs->sum('duration_minutes') ?? 0;
        });

        $daysCount = $logs->count() ?: 1;

        return [
            Stat::make('Totale Activiteit (7 dagen)', $totalActivity . ' min'),
            Stat::make('Totale Pijn (7 dagen)', $totalPain . ' min'),
            Stat::make('Gemiddelde Activiteit per dag', round($totalActivity / $daysCount) . ' min'),
            Stat::make('Gemiddelde Pijn per dag', round($totalPain / $daysCount) . ' min'),
        ];
    }
}
