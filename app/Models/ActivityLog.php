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

/**
 * @property int $id
 * @property int $day_log_id
 * @property ActivityCategory $activity_category
 * @property string|null $activity_type
 * @property string $start_time
 * @property string $end_time
 * @property int|null $duration_minutes
 * @property int|null $intensity
 * @property int|null $perceived_load
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\DayLog $dayLog
 * @method static \Database\Factories\ActivityLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereActivityCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereActivityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereDayLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereIntensity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog wherePerceivedLoad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog withoutTrashed()
 * @mixin \Eloquent
 */
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
