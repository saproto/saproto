<?php

namespace App\Models;

use Database\Factories\WelcomeMessageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Override;

/**
 * Welcome Message Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static WelcomeMessageFactory factory($count = null, $state = [])
 * @method static Builder<static>|WelcomeMessage newModelQuery()
 * @method static Builder<static>|WelcomeMessage newQuery()
 * @method static Builder<static>|WelcomeMessage query()
 * @method static Builder<static>|WelcomeMessage whereCreatedAt($value)
 * @method static Builder<static>|WelcomeMessage whereId($value)
 * @method static Builder<static>|WelcomeMessage whereMessage($value)
 * @method static Builder<static>|WelcomeMessage whereUpdatedAt($value)
 * @method static Builder<static>|WelcomeMessage whereUserId($value)
 *
 * @mixin \Eloquent
 */
class WelcomeMessage extends Model
{
    /** @use HasFactory<WelcomeMessageFactory>*/
    use HasFactory;

    protected $table = 'user_welcome';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getCacheKey(int $id): string
    {
        return "home.welcomemessage:{$id}";
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (self $welcomeMessage) {
            Cache::forget(self::getCacheKey($welcomeMessage->user_id));
        });
    }
}
