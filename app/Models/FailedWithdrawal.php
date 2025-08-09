<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Failed Withdrawal Model.
 *
 * @property int $id
 * @property int $withdrawal_id
 * @property int $user_id
 * @property int $correction_orderline_id
 * @property-read OrderLine|null $correctionOrderline
 * @property-read User|null $user
 * @property-read Withdrawal|null $withdrawal
 *
 * @method static Builder<static>|FailedWithdrawal newModelQuery()
 * @method static Builder<static>|FailedWithdrawal newQuery()
 * @method static Builder<static>|FailedWithdrawal query()
 * @method static Builder<static>|FailedWithdrawal whereCorrectionOrderlineId($value)
 * @method static Builder<static>|FailedWithdrawal whereId($value)
 * @method static Builder<static>|FailedWithdrawal whereUserId($value)
 * @method static Builder<static>|FailedWithdrawal whereWithdrawalId($value)
 *
 * @mixin \Eloquent
 */
class FailedWithdrawal extends Model
{
    use HasFactory;

    protected $table = 'withdrawals_failed';

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return BelongsTo<OrderLine, $this> */
    public function correctionOrderline(): BelongsTo
    {
        return $this->belongsTo(OrderLine::class, 'correction_orderline_id');
    }

    /**
     * @return HasOne<Withdrawal, $this> */
    public function withdrawal(): HasOne
    {
        return $this->hasOne(Withdrawal::class, 'withdrawal_id');
    }

    /**
     * @return HasOne<User, $this> */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
