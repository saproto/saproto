<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Mollie;

class MollieTransaction extends Model
{
    protected $table = 'mollie_transactions';
    protected $guarded = ['id'];

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine', 'payed_with_mollie');
    }

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function transaction()
    {
        return Mollie::api()->payments()->get($this->mollie_id);
    }
}
