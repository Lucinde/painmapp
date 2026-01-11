<?php

namespace App\Models;

use App\Enums\ActivityCategory;
use App\Traits\CalculateDuration;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes, CalculateDuration;

    protected $fillable = [
        'day_log_id',
        'activity_category',
        'start_time',
        'end_time',
        'duration_minutes',
        'intensity',
        'perceived_load',
        'notes',
    ];

    // Get related DayLog
    public function dayLog(): BelongsTo
    {
        return $this->belongsTo(DayLog::class);
    }

    public function casts(): array
    {
        return [
            'activity_category' => ActivityCategory::class,
        ];
    }
}
