<?php

namespace App\Models;

use Database\Factories\ActivityParticipationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;

/**
 * Activity Participation Model.
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $is_present
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $backup
 * @property-read Activity|null $activity
 * @property-read HelpingCommittee|null $help
 * @property-read User|null $user
 *
 * @method static ActivityParticipationFactory factory($count = null, $state = [])
 * @method static Builder<static>|ActivityParticipation newModelQuery()
 * @method static Builder<static>|ActivityParticipation newQuery()
 * @method static Builder<static>|ActivityParticipation onlyTrashed()
 * @method static Builder<static>|ActivityParticipation query()
 * @method static Builder<static>|ActivityParticipation whereActivityId($value)
 * @method static Builder<static>|ActivityParticipation whereBackup($value)
 * @method static Builder<static>|ActivityParticipation whereCommitteesActivitiesId($value)
 * @method static Builder<static>|ActivityParticipation whereCreatedAt($value)
 * @method static Builder<static>|ActivityParticipation whereId($value)
 * @method static Builder<static>|ActivityParticipation whereIsPresent($value)
 * @method static Builder<static>|ActivityParticipation whereUpdatedAt($value)
 * @method static Builder<static>|ActivityParticipation whereUserId($value)
 * @method static Builder<static>|ActivityParticipation withTrashed()
 * @method static Builder<static>|ActivityParticipation withoutTrashed()
 *
 * @mixin \Eloquent
 */
class ActivityParticipation extends Model
{
    /** @use HasFactory<ActivityParticipationFactory>*/
    use HasFactory;

    protected $table = 'activities_users';

    protected $guarded = ['id'];

    protected $casts = [
        'backup' => 'boolean',
        'is_present' => 'boolean',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Activity, $this>
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
