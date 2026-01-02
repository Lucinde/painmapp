<?php

namespace App\Models;

use App\Enums\PainLocation;
use App\Traits\CalculateDuration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PainLog extends Model
{
    use HasFactory, SoftDeletes, CalculateDuration;

    protected $fillable = [
        'day_log_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'location',
        'intensity',
        'notes',
    ];

    // Get related DayLog
    public function dayLog(): BelongsTo
    {
        return $this->belongsTo(DayLog::class);
    }

    protected function casts(): array
    {
        return [
            'location' => AsEnumCollection::of(PainLocation::class),
        ];
    }
}
