<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Good Idea Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $idea
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read Collection|GoodIdeaVote[] $votes
 * @method static Builder|GoodIdea whereCreatedAt($value)
 * @method static Builder|GoodIdea whereId($value)
 * @method static Builder|GoodIdea whereIdea($value)
 * @method static Builder|GoodIdea whereUpdatedAt($value)
 * @method static Builder|GoodIdea whereUserId($value)
 * @method static Builder|GoodIdea newModelQuery()
 * @method static Builder|GoodIdea newQuery()
 * @method static Builder|GoodIdea query()
 * @mixin Eloquent
 */
class GoodIdea extends Model
{
    use SoftDeletes;

    protected $table = 'good_ideas';

    protected $guarded = ['id'];

    /** @return BelongsTo */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    /** @return HasMany */
    public function votes()
    {
        return $this->hasMany('Proto\Models\GoodIdeaVote');
    }

    /** @return int */
    public function voteScore()
    {
        return $this->votes()->sum('vote');
    }

    /**
     * @param User $user
     * @return int
     */
    public function userVote($user)
    {
        /** @var GoodIdeaVote $vote */
        $vote = $this->votes()->where('user_id', $user->id)->first();
        if ($vote != null) {
            return $vote->vote;
        }
        return 0;
    }
}
