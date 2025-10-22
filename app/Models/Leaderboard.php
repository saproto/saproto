<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Override;

/**
 * Leaderboard Model.
 *
 * @property int $id
 * @property int $committee_id
 * @property string $name
 * @property bool $featured
 * @property string $description
 * @property string|null $icon
 * @property string|null $points_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Committee|null $committee
 * @property-read Collection<int, LeaderboardEntry> $entries
 * @property-read int|null $entries_count
 *
 * @method static Builder<static>|Leaderboard newModelQuery()
 * @method static Builder<static>|Leaderboard newQuery()
 * @method static Builder<static>|Leaderboard query()
 * @method static Builder<static>|Leaderboard whereCommitteeId($value)
 * @method static Builder<static>|Leaderboard whereCreatedAt($value)
 * @method static Builder<static>|Leaderboard whereDescription($value)
 * @method static Builder<static>|Leaderboard whereFeatured($value)
 * @method static Builder<static>|Leaderboard whereIcon($value)
 * @method static Builder<static>|Leaderboard whereId($value)
 * @method static Builder<static>|Leaderboard whereName($value)
 * @method static Builder<static>|Leaderboard wherePointsName($value)
 * @method static Builder<static>|Leaderboard whereUpdatedAt($value)
 *
 * @mixin Model
 */
class Leaderboard extends Model
{
    protected $table = 'leaderboards';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Committee, $this>
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }

    /**
     * @return HasMany<LeaderboardEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(LeaderboardEntry::class);
    }

    public static function isAdminAny(User $user): bool
    {
        return Leaderboard::query()->whereRelation('committee.users', 'users.id', $user->id)->exists();
    }

    public function canEdit(User $user): bool
    {
        if ($user->can('board')) {
            return true;
        }

        return $this->committee->users->contains($user);
    }

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('leaderboard.leaderboard');
        });
    }
}
