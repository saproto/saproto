<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Database\Eloquent\
{
    Builder,
    Model,
    Relations\BelongsTo,
    Relations\HasOne
};

/**
 * Failed Withdrawal Model
 *
 * @property int $id
 * @property int $withdrawal_id
 * @property int $user_id
 * @property int $correction_orderline_id
 * @property-read OrderLine $correction_orderline
 * @property-read User $user
 * @property-read Withdrawal $withdrawal
 * @method static Builder|FailedWithdrawal whereCorrectionOrderlineId($value)
 * @method static Builder|FailedWithdrawal whereId($value)
 * @method static Builder|FailedWithdrawal whereUserId($value)
 * @method static Builder|FailedWithdrawal whereWithdrawalId($value)
 * @mixin Eloquent
 */
class FailedWithdrawal extends Model
{

    protected $table = 'withdrawals_failed';
    
    protected $guarded = ['id'];
    
    public $timestamps = false;

    /** @return BelongsTo|OrderLine */
    public function correctionOrderline()
    {
        return $this->belongsTo('Proto\Models\OrderLine', 'correction_orderline_id');
    }

    /** @return HasOne|Withdrawal */
    public function withdrawal()
    {
        return $this->hasOne('Proto\Models\Withdrawal', 'withdrawal_id');
    }

    /** @return HasOne|User */
    public function user()
    {
        return $this->hasOne('Proto\Models\User', 'user_id');
    }

}
