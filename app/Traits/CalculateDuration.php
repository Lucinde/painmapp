<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateDuration
{
    protected static function bootCalculateDuration(): void
    {
        static::saving(function ($model) {
            if ($model->start_time && $model->end_time) {
                $model->duration_minutes =
                    Carbon::parse($model->start_time)
                        ->diffInMinutes(Carbon::parse($model->end_time));
            }
        });
    }
}
