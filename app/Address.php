<?php

namespace Proto;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table  = 'addresses';

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
