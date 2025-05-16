<?php

namespace App\Models;

use Database\Factories\CommitteeMembershipFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;

/**
 * Committee Membership Model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $committee_id
 * @property string|null $role
 * @property string|null $edition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Committee|null $committee
 * @property-read User|null $user
 *
 * @method static CommitteeMembershipFactory factory($count = null, $state = [])
 * @method static Builder<static>|CommitteeMembership newModelQuery()
 * @method static Builder<static>|CommitteeMembership newQuery()
 * @method static Builder<static>|CommitteeMembership onlyTrashed()
 * @method static Builder<static>|CommitteeMembership query()
 * @method static Builder<static>|CommitteeMembership whereCommitteeId($value)
 * @method static Builder<static>|CommitteeMembership whereCreatedAt($value)
 * @method static Builder<static>|CommitteeMembership whereDeletedAt($value)
 * @method static Builder<static>|CommitteeMembership whereEdition($value)
 * @method static Builder<static>|CommitteeMembership whereId($value)
 * @method static Builder<static>|CommitteeMembership whereRole($value)
 * @method static Builder<static>|CommitteeMembership whereUpdatedAt($value)
 * @method static Builder<static>|CommitteeMembership whereUserId($value)
 * @method static Builder<static>|CommitteeMembership withTrashed()
 * @method static Builder<static>|CommitteeMembership withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CommitteeMembership extends Model
{
    /** @use HasFactory<CommitteeMembershipFactory>*/
    use HasFactory;

    use SoftDeletes;

    protected $table = 'committees_users';

    protected $guarded = ['id'];

    protected $hidden = ['id', 'committee_id', 'user_id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Committee, $this>
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
