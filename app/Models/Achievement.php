<?php

namespace App\Models;

use App\Enums\MembershipTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Achievement Model.
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property string|null $fa_icon
 * @property string $tier
 * @property bool $has_page
 * @property string|null $page_name
 * @property string|null $page_content
 * @property bool $is_archived
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, AchievementOwnership> $achievementOwnership
 * @property-read int|null $achievement_ownership_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder<static>|Achievement newModelQuery()
 * @method static Builder<static>|Achievement newQuery()
 * @method static Builder<static>|Achievement query()
 * @method static Builder<static>|Achievement whereCreatedAt($value)
 * @method static Builder<static>|Achievement whereDesc($value)
 * @method static Builder<static>|Achievement whereFaIcon($value)
 * @method static Builder<static>|Achievement whereHasPage($value)
 * @method static Builder<static>|Achievement whereId($value)
 * @method static Builder<static>|Achievement whereIsArchived($value)
 * @method static Builder<static>|Achievement whereName($value)
 * @method static Builder<static>|Achievement wherePageContent($value)
 * @method static Builder<static>|Achievement wherePageName($value)
 * @method static Builder<static>|Achievement whereTier($value)
 * @method static Builder<static>|Achievement whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Achievement extends Model
{
    protected $table = 'achievement';

    protected $guarded = ['id'];

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'achievements_users');
    }

    /**
     * @return HasMany<AchievementOwnership, $this>
     */
    public function achievementOwnership(): HasMany
    {
        return $this->hasMany(AchievementOwnership::class);
    }

    public function numberOfStars(): int
    {
        $map = [
            'COMMON' => 1,
            'UNCOMMON' => 2,
            'RARE' => 3,
            'EPIC' => 4,
            'LEGENDARY' => 5,
        ];

        return $map[$this->tier];
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function currentOwners(bool $is_member = true): BelongsToMany
    {
        if ($is_member) {
            return $this->users()->whereHas('member', static function (\Illuminate\Contracts\Database\Query\Builder $query) {
                $query->whereNot('membership_type', MembershipTypeEnum::PENDING);
            });
        }

        return $this->users();
    }

    protected function casts(): array
    {
        return [
            'has_page' => 'boolean',
            'is_archived' => 'boolean',
        ];
    }
}
