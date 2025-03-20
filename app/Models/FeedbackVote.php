<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Proto\Models\FeedbackVote.
 *
 * @property int $id
 * @property int $user_id
 * @property int $feedback_id
 * @property int $vote
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Feedback $feedback
 *
 * @method static Builder|FeedbackVote whereCreatedAt($value)
 * @method static Builder|FeedbackVote whereFeedbackId($value)
 * @method static Builder|FeedbackVote whereId($value)
 * @method static Builder|FeedbackVote whereUpdatedAt($value)
 * @method static Builder|FeedbackVote whereUserId($value)
 * @method static Builder|FeedbackVote whereVote($value)
 * @method static Builder|FeedbackVote newModelQuery()
 * @method static Builder|FeedbackVote newQuery()
 * @method static Builder|FeedbackVote query()
 *
 * @mixin Model
 */
class FeedbackVote extends Model
{
    protected $table = 'feedback_votes';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Feedback, $this>
     */
    public function feedback(): BelongsTo
    {
        return $this->belongsTo(Feedback::class);
    }

    /**
     * @return HasOne<User, $this>
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
