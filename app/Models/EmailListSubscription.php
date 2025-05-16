<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Email List Subscription Model.
 *
 * @property int $id
 * @property int $list_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read EmailList|null $emaillist
 * @property-read User|null $user
 *
 * @method static Builder<static>|EmailListSubscription newModelQuery()
 * @method static Builder<static>|EmailListSubscription newQuery()
 * @method static Builder<static>|EmailListSubscription query()
 * @method static Builder<static>|EmailListSubscription whereCreatedAt($value)
 * @method static Builder<static>|EmailListSubscription whereId($value)
 * @method static Builder<static>|EmailListSubscription whereListId($value)
 * @method static Builder<static>|EmailListSubscription whereUpdatedAt($value)
 * @method static Builder<static>|EmailListSubscription whereUserId($value)
 *
 * @mixin \Eloquent
 */
class EmailListSubscription extends Model
{
    protected $table = 'users_mailinglists';

    protected $guarded = ['id'];

    /**
     * @return HasOne<User, $this> */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return BelongsTo<EmailList, $this> */
    public function emaillist(): BelongsTo
    {
        return $this->belongsTo(EmailList::class, 'list_id');
    }
}
