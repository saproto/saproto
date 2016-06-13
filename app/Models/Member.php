<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
