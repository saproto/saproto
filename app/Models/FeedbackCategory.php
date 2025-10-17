<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Feedback model.
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property bool $review
 * @property int|null $reviewer_id
 * @property bool $show_publisher
 * @property bool $can_reply
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Feedback> $feedback
 * @property-read int|null $feedback_count
 * @property-read User|null $reviewer
 *
 * @method static Builder<static>|FeedbackCategory newModelQuery()
 * @method static Builder<static>|FeedbackCategory newQuery()
 * @method static Builder<static>|FeedbackCategory query()
 * @method static Builder<static>|FeedbackCategory whereCanReply($value)
 * @method static Builder<static>|FeedbackCategory whereCreatedAt($value)
 * @method static Builder<static>|FeedbackCategory whereId($value)
 * @method static Builder<static>|FeedbackCategory whereReview($value)
 * @method static Builder<static>|FeedbackCategory whereReviewerId($value)
 * @method static Builder<static>|FeedbackCategory whereShowPublisher($value)
 * @method static Builder<static>|FeedbackCategory whereTitle($value)
 * @method static Builder<static>|FeedbackCategory whereUpdatedAt($value)
 * @method static Builder<static>|FeedbackCategory whereUrl($value)
 *
 * @mixin Model
 */
class FeedbackCategory extends Model
{
    protected $table = 'feedback_categories';

    protected $guarded = ['id'];

    /**
     * @return HasMany<Feedback, $this>
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'feedback_category_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    protected function casts(): array
    {
        return [
            'review' => 'boolean',
            'show_publisher' => 'boolean',
            'can_reply' => 'boolean',
        ];
    }
}
