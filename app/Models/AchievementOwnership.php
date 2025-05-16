<?php

namespace App\Models;

use Database\Factories\AchievementOwnershipFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Achievement Ownership Model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $achievement_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $alerted
 * @property string|null $description
 * @property-read Achievement|null $achievement
 * @property-read User|null $user
 *
 * @method static AchievementOwnershipFactory factory($count = null, $state = [])
 * @method static Builder<static>|AchievementOwnership newModelQuery()
 * @method static Builder<static>|AchievementOwnership newQuery()
 * @method static Builder<static>|AchievementOwnership query()
 * @method static Builder<static>|AchievementOwnership whereAchievementId($value)
 * @method static Builder<static>|AchievementOwnership whereAlerted($value)
 * @method static Builder<static>|AchievementOwnership whereCreatedAt($value)
 * @method static Builder<static>|AchievementOwnership whereDescription($value)
 * @method static Builder<static>|AchievementOwnership whereId($value)
 * @method static Builder<static>|AchievementOwnership whereUpdatedAt($value)
 * @method static Builder<static>|AchievementOwnership whereUserId($value)
 *
 * @mixin \Eloquent
 */
class AchievementOwnership extends Model
{
    /** @use HasFactory<AchievementOwnershipFactory>*/
    use HasFactory;

    protected $table = 'achievements_users';

    protected $guarded = ['id'];

    protected $hidden = ['user_id'];

    /** @var array|string[] */
    protected array $rules = [
        'user_id' => 'required|integer',
        'achievement_id' => 'required|integer',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Achievement, $this>
     */
    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }

    protected function casts(): array
    {
        return [
            'alerted' => 'boolean',
        ];
    }
}
