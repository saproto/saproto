<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Crypt;

/**
 * Email List Model.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $is_member_only
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder<static>|EmailList newModelQuery()
 * @method static Builder<static>|EmailList newQuery()
 * @method static Builder<static>|EmailList query()
 * @method static Builder<static>|EmailList subscribed(User $user)
 * @method static Builder<static>|EmailList whereDescription($value)
 * @method static Builder<static>|EmailList whereId($value)
 * @method static Builder<static>|EmailList whereIsMemberOnly($value)
 * @method static Builder<static>|EmailList whereName($value)
 *
 * @mixin Model
 */
class EmailList extends Model
{
    protected $table = 'mailinglists';

    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_mailinglists', 'list_id', 'user_id');
    }

    /**
     * @return bool Whether a user is subscribed to the mailing list.
     */
    public function isSubscribed(User $user): bool
    {
        return EmailListSubscription::query()->where('user_id', $user->id)->where('list_id', $this->id)->count() > 0;
    }

    /** @param Builder<$this> $query
     * @return Builder<$this>
     */
    protected function scopeSubscribed(Builder $query, User $user): Builder
    {
        return $query->whereHas('users', function (\Illuminate\Contracts\Database\Query\Builder $q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    /**
     * @return bool Whether user is successfully subscribed to mailing list.
     */
    public function subscribe(User $user): bool
    {
        if (! $this->isSubscribed($user)) {
            EmailListSubscription::query()->create([
                'user_id' => $user->id,
                'list_id' => $this->id,
            ]);

            return true;
        }

        return false;
    }

    /**
     * @return bool Whether user is successfully unsubscribed from mailing list.
     *
     * @throws Exception
     */
    public function unsubscribe(User $user): bool
    {
        $s = EmailListSubscription::query()->where('user_id', $user->id)->where('list_id', $this->id);
        if ($s == null) {
            return false;
        }

        $s->delete();

        return true;
    }

    public static function generateUnsubscribeHash(int $user_id, int $list_id): string
    {
        return base64_encode(Crypt::encrypt(json_encode(['user' => $user_id, 'list' => $list_id])));
    }

    /**
     * @return object{
     *     user: int,
     *     list: int
     * }
     */
    public static function parseUnsubscribeHash(string $hash): mixed
    {
        return json_decode(Crypt::decrypt(base64_decode($hash)));
    }
}
