<?php

namespace App\Models;

use Database\Factories\BankFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Bank Account Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $iban
 * @property string $bic
 * @property string $machtigingid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static BankFactory factory($count = null, $state = [])
 * @method static Builder<static>|Bank newModelQuery()
 * @method static Builder<static>|Bank newQuery()
 * @method static Builder<static>|Bank query()
 * @method static Builder<static>|Bank whereBic($value)
 * @method static Builder<static>|Bank whereCreatedAt($value)
 * @method static Builder<static>|Bank whereIban($value)
 * @method static Builder<static>|Bank whereId($value)
 * @method static Builder<static>|Bank whereMachtigingid($value)
 * @method static Builder<static>|Bank whereUpdatedAt($value)
 * @method static Builder<static>|Bank whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Bank extends Model
{
    /** @use HasFactory<BankFactory>*/
    use HasFactory;

    protected $table = 'bankaccounts';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
