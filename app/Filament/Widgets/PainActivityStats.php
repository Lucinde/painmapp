<?php

namespace App\Filament\Widgets;

use App\Models\DayLog;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PainActivityStats extends StatsOverviewWidget
{
    use HasWidgetShield;

    public function getHeading(): string
    {
        return __('daylog.activity_logs.statistics');
    }

    protected function getStats(): array
    {
        // Vandaag
        $today = now()->toDateString();

        $todayLog = DayLog::with(['activityLogs', 'painLogs'])
            ->where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        $todayActivity = $todayLog?->activityLogs->sum('duration_minutes') ?? 0;
        $todayPain = $todayLog?->painLogs->sum('duration_minutes') ?? 0;

        // Laatste 7 dagen (incl. vandaag)
        $startDate = now()->subDays(6)->toDateString();
        $endDate = now()->toDateString();

        $logs = DayLog::with(['activityLogs', 'painLogs'])
            ->where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalActivity = $logs->sum(fn ($log) =>
            $log->activityLogs->sum('duration_minutes') ?? 0
        );

        $totalPain = $logs->sum(fn ($log) =>
            $log->painLogs->sum('duration_minutes') ?? 0
        );

        $daysCount = max($logs->count(), 1);

        return [
            Stat::make(__('daylog.activity_logs.activity_today'), $todayActivity . ' min'),
            Stat::make(__('daylog.activity_logs.pain_today'), $todayPain . ' min'),
            Stat::make(
                __('daylog.activity_logs.average_activity_day'),
                round($totalActivity / $daysCount) . ' min'
            )->description(__('daylog.activity_logs.last_7_days')),
            Stat::make(
                __('daylog.activity_logs.average_pain_day'),
                round($totalPain / $daysCount) . ' min'
            )->description(__('daylog.activity_logs.last_7_days')),
        ];
    }
}
