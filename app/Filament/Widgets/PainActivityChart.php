<?php

namespace App\Filament\Widgets;

use App\Models\DayLog;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PainActivityChart extends ChartWidget
{
    use HasWidgetShield;

    public function getHeading(): string
    {
        return __('daylog.activity_logs.activity_vs_pain');
    }
    protected int|string|array $columnSpan = 'full';

    protected function getFilters(): ?array
    {
        $months = [
            'last30' => __('daylog.activity_logs.last_30_days'),
        ];

        // Laat de laatste 12 maanden zien in de keuzelijst
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $months[$date->format('Y-m')] = $date->translatedFormat('F Y');
        }

        return $months;
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'last30';

        if ($filter === 'last30') {
            $startDate = now()->subDays(30);
            $endDate = now();
        } else {
            [$year, $month] = explode('-', $filter);
            $startDate = Carbon::createFromDate((int) $year, (int) $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        }

        $logs = DayLog::with(['activityLogs', 'painLogs'])
            ->where('user_id', auth()->id()) // filter op ingelogde gebruiker
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        $labels = [];
        $activityData = [];
        $painData = [];

        foreach ($logs as $log) {
            $labels[] = Carbon::parse($log->date)->format('d M');

            $totalActivity = $log->activityLogs->sum('duration_minutes') ?? 0;
            $activityData[] = $totalActivity;

            $totalPain = $log->painLogs->sum('duration_minutes') ?? 0;
            $painData[] = $totalPain;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('daylog.activity_logs.activity_label'),
                    'data' => $activityData,
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(255, 206, 86, 0.8)', // geel
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => __('daylog.activity_logs.pain_label'),
                    'data' => $painData,
                    'type' => 'line',
                    'borderColor' => 'rgba(54, 162, 235, 1)', // blauw
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgba(54, 162, 235, 1)',
                    'yAxisID' => 'y1',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): ?array
    {
        return [
            'responsive' => true,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'y' => [
                    'title' => ['display' => true, 'text' => __('daylog.activity_logs.activity_label')],
                ],
                'y1' => [
                    'position' => 'right',
                    'grid' => ['drawOnChartArea' => false],
                    'title' => ['display' => true, 'text' => __('daylog.activity_logs.pain_label')],
                ],
            ],
        ];
    }
}
