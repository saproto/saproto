<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $rules = array(
    );

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
