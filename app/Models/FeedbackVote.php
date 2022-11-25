<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Proto\Models\GoodIdeaVote.
 *
 * @property int $id
 * @property int $user_id
 * @property int $good_idea_id
 * @property int $vote
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Feedback $goodIdea
 * @method static Builder|FeedbackVote whereCreatedAt($value)
 * @method static Builder|FeedbackVote whereGoodIdeaId($value)
 * @method static Builder|FeedbackVote whereId($value)
 * @method static Builder|FeedbackVote whereUpdatedAt($value)
 * @method static Builder|FeedbackVote whereUserId($value)
 * @method static Builder|FeedbackVote whereVote($value)
 * @method static Builder|FeedbackVote newModelQuery()
 * @method static Builder|FeedbackVote newQuery()
 * @method static Builder|FeedbackVote query()
 * @mixin Eloquent
 */
class FeedbackVote extends Model
{
    protected $table = 'feedback_votes';

    protected $guarded = ['id'];

    /** @return HasOne */
    public function feedback(): HasOne
    {
        return $this->hasOne('Proto\Models\Feedback');
    }
}
