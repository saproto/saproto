<?php

namespace Proto;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';

    public function user()
    {
        return $this->belongsToMany('Proto\User');
    }
}
