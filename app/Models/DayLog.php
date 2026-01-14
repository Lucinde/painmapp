<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\DayLogFactory factory($count = null, $state = [])
 * @method static Builder<static>|DayLog fromUser(int $userId)
 * @method static Builder<static>|DayLog newModelQuery()
 * @method static Builder<static>|DayLog newQuery()
 * @method static Builder<static>|DayLog onlyTrashed()
 * @method static Builder<static>|DayLog query()
 * @method static Builder<static>|DayLog withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|DayLog withoutTrashed()
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityLog> $activityLogs
 * @property-read int|null $activity_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PainLog> $painLogs
 * @property-read int|null $pain_logs_count
 * @method static Builder<static>|DayLog whereCreatedAt($value)
 * @method static Builder<static>|DayLog whereDate($value)
 * @method static Builder<static>|DayLog whereDeletedAt($value)
 * @method static Builder<static>|DayLog whereId($value)
 * @method static Builder<static>|DayLog whereNotes($value)
 * @method static Builder<static>|DayLog whereUpdatedAt($value)
 * @method static Builder<static>|DayLog whereUserId($value)
 * @mixin \Eloquent
 */
class DayLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    // Get all daylogs for current user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Get all related painlogs
    public function painLogs(): HasMany
    {
        return $this->hasMany(PainLog::class);
    }

    // Get all related activitylogs
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Get all daylogs from specific user
    #[Scope]
    protected function fromUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }



}
