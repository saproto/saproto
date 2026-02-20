<?php

namespace App\Models;

use Database\Factories\FeedbackFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;

/**
 * Feedback model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $feedback_category_id
 * @property string $feedback
 * @property bool $reviewed
 * @property bool|null $accepted
 * @property string|null $reply
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read FeedbackCategory|null $category
 * @property-read User|null $user
 * @property-read Collection<int, FeedbackVote> $votes
 * @property-read int|null $votes_count
 *
 * @method static FeedbackFactory factory($count = null, $state = [])
 * @method static Builder<static>|Feedback newModelQuery()
 * @method static Builder<static>|Feedback newQuery()
 * @method static Builder<static>|Feedback onlyTrashed()
 * @method static Builder<static>|Feedback query()
 * @method static Builder<static>|Feedback whereAccepted($value)
 * @method static Builder<static>|Feedback whereCreatedAt($value)
 * @method static Builder<static>|Feedback whereDeletedAt($value)
 * @method static Builder<static>|Feedback whereFeedback($value)
 * @method static Builder<static>|Feedback whereFeedbackCategoryId($value)
 * @method static Builder<static>|Feedback whereId($value)
 * @method static Builder<static>|Feedback whereReply($value)
 * @method static Builder<static>|Feedback whereReviewed($value)
 * @method static Builder<static>|Feedback whereUpdatedAt($value)
 * @method static Builder<static>|Feedback whereUserId($value)
 * @method static Builder<static>|Feedback withTrashed()
 * @method static Builder<static>|Feedback withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    /** @use HasFactory<FeedbackFactory>*/
    use HasFactory;

    use SoftDeletes;

    protected $table = 'feedback';

    protected $guarded = ['id'];

    protected $with = ['user', 'category'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<FeedbackCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }

    /**
     * @return HasMany<FeedbackVote, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(FeedbackVote::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'reviewed' => 'boolean',
            'accepted' => 'boolean',
        ];
    }
}
