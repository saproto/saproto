<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Activity Participation Model.
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property int $is_present
 * @property int|null $committees_activities_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $backup
 * @property Carbon|null $deleted_at
 * @property-read Activity $activity
 * @property-read HelpingCommittee|null $help
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static Builder|ActivityParticipation onlyTrashed()
 * @method static bool|null restore()
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
 * @mixin Eloquent
 */
class ActivityParticipation extends Model
{
    use SoftDeletes;

    protected $table = 'activities_users';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo|Activity */
    public function activity()
    {
        return $this->belongsTo('Proto\Models\Activity');
    }

    /** @return BelongsTo */
    public function help()
    {
        return $this->belongsTo('Proto\Models\HelpingCommittee', 'committees_activities_id');
    }
}
