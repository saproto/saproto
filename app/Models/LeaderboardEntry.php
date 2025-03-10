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
 * @property-read Leaderboard $leaderboard
 * @property-read User $user
 *
 * @method static Builder|LeaderboardEntry whereCreatedAt($value)
 * @method static Builder|LeaderboardEntry whereId($value)
 * @method static Builder|LeaderboardEntry whereLeaderboardId($value)
 * @method static Builder|LeaderboardEntry wherePoints($value)
 * @method static Builder|LeaderboardEntry whereUpdatedAt($value)
 * @method static Builder|LeaderboardEntry whereUserId($value)
 * @method static Builder|LeaderboardEntry newModelQuery()
 * @method static Builder|LeaderboardEntry newQuery()
 * @method static Builder|LeaderboardEntry query()
 *
 * @mixin Model
 */
class LeaderboardEntry extends Model
{
    protected $table = 'leaderboards_entries';

    protected $guarded = ['id'];

    public function leaderboard(): BelongsTo
    {
        return $this->belongsTo(Leaderboard::class, 'leaderboard_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
