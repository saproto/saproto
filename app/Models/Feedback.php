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

/**
 * Feedback model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $feedback
 * @property User|null $reply
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $reviewed
 * @property bool|null $accepted
 * @property FeedbackCategory|null $category
 * @property-read User|null $user
 * @property-read Collection|FeedbackVote[] $votes
 *
 * @method static Builder|Feedback whereCreatedAt($value)
 * @method static Builder|Feedback whereId($value)
 * @method static Builder|Feedback whereFeedback($value)
 * @method static Builder|Feedback whereUpdatedAt($value)
 * @method static Builder|Feedback whereUserId($value)
 * @method static Builder|Feedback newModelQuery()
 * @method static Builder|Feedback newQuery()
 * @method static Builder|Feedback query()
 *
 * @mixin Model
 *
 * @property int $feedback_category_id
 * @property Carbon|null $deleted_at
 * @property-read int|null $votes_count
 *
 * @method static FeedbackFactory factory($count = null, $state = [])
 * @method static Builder<static>|Feedback onlyTrashed()
 * @method static Builder<static>|Feedback whereAccepted($value)
 * @method static Builder<static>|Feedback whereDeletedAt($value)
 * @method static Builder<static>|Feedback whereFeedbackCategoryId($value)
 * @method static Builder<static>|Feedback whereReply($value)
 * @method static Builder<static>|Feedback whereReviewed($value)
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
}
