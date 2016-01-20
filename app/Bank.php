<?php

namespace Proto;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bankaccounts';

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
