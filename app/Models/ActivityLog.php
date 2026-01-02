<?php

namespace App\Models;

use App\Traits\CalculateDuration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes, CalculateDuration;

    protected $fillable = [
        'day_log_id',
        'activity_category',
        'start_time',
        'end_time',
        'duration_minutes',
        'intensity_level',
        'perceived_load',
        'notes',
    ];

    // Get related DayLog
    public function dayLog(): BelongsTo
    {
        return $this->belongsTo(DayLog::class);
    }
}
