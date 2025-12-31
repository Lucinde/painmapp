<?php

namespace App\Models;

use App\Enums\PainLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PainLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'day_log_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'location',
        'intensity',
        'notes',
    ];

    public function dayLog(): BelongsTo
    {
        return $this->belongsTo(DayLog::class);
    }

    // calculate duration minutes when saving log
    protected static function booted(): void
    {
        static::saving(function ($painLog) {
            if ($painLog->start_time && $painLog->end_time) {
                $painLog->duration_minutes =
                    Carbon::parse($painLog->start_time)
                        ->diffInMinutes(
                            Carbon::parse($painLog->end_time)
                        );
            }
        });
    }

    protected function casts(): array
    {
        return [
            'location' => AsEnumCollection::of(PainLocation::class),
        ];
    }
}
