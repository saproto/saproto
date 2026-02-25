<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Helping Committee Model.
 *
 * @property int $id
 * @property int $activity_id
 * @property int $committee_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Activity|null $activity
 * @property-read Committee|null $committee
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder<static>|HelpingCommittee newModelQuery()
 * @method static Builder<static>|HelpingCommittee newQuery()
 * @method static Builder<static>|HelpingCommittee query()
 * @method static Builder<static>|HelpingCommittee whereActivityId($value)
 * @method static Builder<static>|HelpingCommittee whereAmount($value)
 * @method static Builder<static>|HelpingCommittee whereCommitteeId($value)
 * @method static Builder<static>|HelpingCommittee whereCreatedAt($value)
 * @method static Builder<static>|HelpingCommittee whereId($value)
 * @method static Builder<static>|HelpingCommittee whereNotificationSent($value)
 * @method static Builder<static>|HelpingCommittee whereUpdatedAt($value)
 *
 * @mixin Model
 */
class HelpingCommittee extends Validatable
{
    protected $table = 'committees_activities';

    protected $guarded = ['id'];

    /** @var array|string[] */
    protected array $rules = [
        'activity_id' => 'required|integer',
        'committee_id' => 'required|integer',
        'amount' => 'required|integer',
    ];

    /**
     * @return BelongsTo<Activity, $this>
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * @return BelongsTo<Committee, $this>
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'activities_helpers', 'committees_activities_id');
    }
}
