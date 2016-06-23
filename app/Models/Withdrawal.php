<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{

    protected $table = 'withdrawals';
    protected $guarded = [/*'id'*/];

    public function orderlines()
    {
        return $this->belongsTo('Proto\Models\OrderLine', 'payed_with_withdrawal');
    }

}
