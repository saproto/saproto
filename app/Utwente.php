<?php

namespace Proto;

use Illuminate\Database\Eloquent\Model;

class Utwente extends Model
{
    protected $table = 'utwentes';

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
