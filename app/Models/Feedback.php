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
 * @property-read Collection|FeedbackVote[] $votes
 * @method static Builder|Feedback whereCreatedAt($value)
 * @method static Builder|Feedback whereId($value)
 * @method static Builder|Feedback whereIdea($value)
 * @method static Builder|Feedback whereUpdatedAt($value)
 * @method static Builder|Feedback whereUserId($value)
 * @method static Builder|Feedback newModelQuery()
 * @method static Builder|Feedback newQuery()
 * @method static Builder|Feedback query()
 * @mixin Eloquent
 */
class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'feedback';

    protected $guarded = ['id'];

    /** @return BelongsTo */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    /** @return BelongsTo */
    public function goodIdeaCategory()
    {
        return $this->belongsTo('Proto\Models\FeedbackCategory', 'feedback_category_id');
    }

    /** @return HasMany */
    public function votes()
    {
        return $this->hasMany('Proto\Models\FeedbackVote');
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
        /** @var FeedbackVote $vote */
        $vote = $this->votes()->where('user_id', $user->id)->first();
        if ($vote != null) {
            return $vote->vote;
        }
        return 0;
    }
}
