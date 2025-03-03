<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

/**
 * Activity Participation Model.
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property int|null $committees_activities_id
 * @property bool $is_present
 * @property bool $backup
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Activity|null $activity
 * @property-read HelpingCommittee|null $help
 * @property-read User|null $user
 *
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static Builder|ActivityParticipation onlyTrashed()
 * @method static Builder|ActivityParticipation whereActivityId($value)
 * @method static Builder|ActivityParticipation whereBackup($value)
 * @method static Builder|ActivityParticipation whereCommitteesActivitiesId($value)
 * @method static Builder|ActivityParticipation whereCreatedAt($value)
 * @method static Builder|ActivityParticipation whereDeletedAt($value)
 * @method static Builder|ActivityParticipation whereId($value)
 * @method static Builder|ActivityParticipation whereIsPresent($value)
 * @method static Builder|ActivityParticipation whereUpdatedAt($value)
 * @method static Builder|ActivityParticipation whereUserId($value)
 * @method static Builder|ActivityParticipation withTrashed()
 * @method static Builder|ActivityParticipation withoutTrashed()
 * @method static Builder|ActivityParticipation newModelQuery()
 * @method static Builder|ActivityParticipation newQuery()
 * @method static Builder|ActivityParticipation query()
 *
 * @mixin Model
 */
class ActivityParticipation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'activities_users';

    protected $guarded = ['id'];

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

    /**
     * @return BelongsTo<HelpingCommittee, $this>
     */
    public function help(): BelongsTo
    {
        return $this->belongsTo(HelpingCommittee::class, 'committees_activities_id');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
