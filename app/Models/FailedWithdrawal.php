<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class FailedWithdrawal extends Model
{
    protected $table = 'withdrawals_failed';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function correction_orderline()
    {
        return $this->belongsTo('Proto\Models\OrderLine', 'correction_orderline_id');
    }

    public function withdrawal()
    {
        return $this->hasOne('Proto\Models\Withdrawal', 'withdrawal_id');
    }

    public function user()
    {
        return $this->hasOne('Proto\Models\User', 'user_id');
    }
}
