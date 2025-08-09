<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Rfid Card Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $card_id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static Builder<static>|RfidCard newModelQuery()
 * @method static Builder<static>|RfidCard newQuery()
 * @method static Builder<static>|RfidCard query()
 * @method static Builder<static>|RfidCard whereCardId($value)
 * @method static Builder<static>|RfidCard whereCreatedAt($value)
 * @method static Builder<static>|RfidCard whereId($value)
 * @method static Builder<static>|RfidCard whereName($value)
 * @method static Builder<static>|RfidCard whereUpdatedAt($value)
 * @method static Builder<static>|RfidCard whereUserId($value)
 *
 * @mixin \Eloquent
 */
class RfidCard extends Model
{
    use HasFactory;

    protected $table = 'rfid';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
