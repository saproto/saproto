<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Welcome Message Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static Builder|WelcomeMessage whereCreatedAt($value)
 * @method static Builder|WelcomeMessage whereId($value)
 * @method static Builder|WelcomeMessage whereMessage($value)
 * @method static Builder|WelcomeMessage whereUpdatedAt($value)
 * @method static Builder|WelcomeMessage whereUserId($value)
 * @method static Builder|WelcomeMessage newModelQuery()
 * @method static Builder|WelcomeMessage newQuery()
 * @method static Builder|WelcomeMessage query()
 *
 * @mixin Model
 */
class WelcomeMessage extends Model
{
    use HasFactory;

    protected $table = 'user_welcome';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
