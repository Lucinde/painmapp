<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateDuration
{
    protected static function bootCalculateDuration(): void
    {
        static::saving(function ($model) {
            if ($model->start_time && $model->end_time) {
                $start = Carbon::parse($model->start_time);
                $end   = Carbon::parse($model->end_time);

                if ($end->lt($start)) {
                    $end->addDay();
                }

                $model->duration_minutes = $start->diffInMinutes($end);
            }
        });
    }
}
