<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Achievement Model.
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property string|null $fa_icon
 * @property string $tier
 * @property int $has_page
 * @property string|null $page_name
 * @property string|null $page_content
 * @property int $is_archived
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $users
 * @property-read Collection|AchievementOwnership[] $achievement_ownership
 * @method static Builder|Achievement whereCreatedAt($value)
 * @method static Builder|Achievement whereDesc($value)
 * @method static Builder|Achievement whereFaIcon($value)
 * @method static Builder|Achievement whereHasPage($value)
 * @method static Builder|Achievement whereId($value)
 * @method static Builder|Achievement whereIsArchived($value)
 * @method static Builder|Achievement whereName($value)
 * @method static Builder|Achievement wherePageContent($value)
 * @method static Builder|Achievement wherePageName($value)
 * @method static Builder|Achievement whereTier($value)
 * @method static Builder|Achievement whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Achievement extends Model
{
    protected $table = 'achievement';

    protected $guarded = ['id'];

    /** @return BelongsToMany|User[] */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'achievements_users');
    }

    /** @return HasMany|AchievementOwnership[] */
    public function achievementOwnership()
    {
        return $this->hasMany('Proto\Models\AchievementOwnership');
    }

    /** @return int */
    public function numberOfStars()
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
     * @param bool $isMember
     * @return User[]
     */
    public function currentOwners($isMember = true)
    {
        $users = [];
        foreach ($this->users as $user) {
            if ((! $isMember || $user->is_member)) {
                $users[] = $user;
            }
        }

        return $users;
    }
}
