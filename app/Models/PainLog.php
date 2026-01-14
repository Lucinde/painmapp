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

/**
 * @property int $id
 * @property int $day_log_id
 * @property string $start_time
 * @property string $end_time
 * @property int|null $duration_minutes
 * @property \Illuminate\Support\Collection<int, PainLocation> $location
 * @property int $intensity
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\DayLog $dayLog
 * @method static \Database\Factories\PainLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereDayLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereIntensity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PainLog withoutTrashed()
 * @mixin \Eloquent
 */
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
