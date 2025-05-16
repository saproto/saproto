<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Token Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static Builder<static>|Token newModelQuery()
 * @method static Builder<static>|Token newQuery()
 * @method static Builder<static>|Token query()
 * @method static Builder<static>|Token whereCreatedAt($value)
 * @method static Builder<static>|Token whereId($value)
 * @method static Builder<static>|Token whereToken($value)
 * @method static Builder<static>|Token whereUpdatedAt($value)
 * @method static Builder<static>|Token whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Token extends Model
{
    protected $table = 'tokens';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function generate(User $user): static
    {
        $this->user_id = $user->id;
        $this->token = uniqid();
        $this->save();

        return $this;
    }
}
