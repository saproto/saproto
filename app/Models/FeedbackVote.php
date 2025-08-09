<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property-read Feedback|null $feedback
 * @property-read User|null $user
 *
 * @method static Builder<static>|FeedbackVote newModelQuery()
 * @method static Builder<static>|FeedbackVote newQuery()
 * @method static Builder<static>|FeedbackVote query()
 * @method static Builder<static>|FeedbackVote whereCreatedAt($value)
 * @method static Builder<static>|FeedbackVote whereFeedbackId($value)
 * @method static Builder<static>|FeedbackVote whereId($value)
 * @method static Builder<static>|FeedbackVote whereUpdatedAt($value)
 * @method static Builder<static>|FeedbackVote whereUserId($value)
 * @method static Builder<static>|FeedbackVote whereVote($value)
 *
 * @mixin \Eloquent
 */
class FeedbackVote extends Model
{
    use HasFactory;

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
