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
 * @property bool $is_first
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static Builder|Bank whereBic($value)
 * @method static Builder|Bank whereCreatedAt($value)
 * @method static Builder|Bank whereIban($value)
 * @method static Builder|Bank whereId($value)
 * @method static Builder|Bank whereIsFirst($value)
 * @method static Builder|Bank whereMachtigingid($value)
 * @method static Builder|Bank whereUpdatedAt($value)
 * @method static Builder|Bank whereUserId($value)
 * @method static Builder|Bank newModelQuery()
 * @method static Builder|Bank newQuery()
 * @method static Builder|Bank query()
 *
 * @mixin Model
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
