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
    public function painlogs(): HasMany
    {
        return $this->hasMany(PainLog::class);
    }

    // Get all daylogs from specific user
    #[Scope]
    protected function fromUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }



}
