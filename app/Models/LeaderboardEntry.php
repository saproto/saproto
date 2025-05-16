<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\LeaderboardEntry.
 *
 * @property int $id
 * @property int $leaderboard_id
 * @property int $user_id
 * @property int $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Leaderboard|null $leaderboard
 * @property-read User|null $user
 *
 * @method static Builder<static>|LeaderboardEntry newModelQuery()
 * @method static Builder<static>|LeaderboardEntry newQuery()
 * @method static Builder<static>|LeaderboardEntry query()
 * @method static Builder<static>|LeaderboardEntry whereCreatedAt($value)
 * @method static Builder<static>|LeaderboardEntry whereId($value)
 * @method static Builder<static>|LeaderboardEntry whereLeaderboardId($value)
 * @method static Builder<static>|LeaderboardEntry wherePoints($value)
 * @method static Builder<static>|LeaderboardEntry whereUpdatedAt($value)
 * @method static Builder<static>|LeaderboardEntry whereUserId($value)
 *
 * @mixin \Eloquent
 */
class LeaderboardEntry extends Model
{
    protected $table = 'leaderboards_entries';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Leaderboard, $this>
     */
    public function leaderboard(): BelongsTo
    {
        return $this->belongsTo(Leaderboard::class, 'leaderboard_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
