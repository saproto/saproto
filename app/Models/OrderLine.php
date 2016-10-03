<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{

    protected $table = 'orderlines';
    protected $guarded = [/*'id'*/];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo('Proto\Models\Product');
    }

    public function cashier()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    public function withdrawal()
    {
        return $this->belongsTo('Proto\Models\Withdrawal', 'payed_with_withdrawal');
    }

    public function isPayed()
    {
        return ($this->payed_with_cash !== null || $this->payed_with_mollie !== null || $this->payed_with_withdrawal !== null);
    }

}
