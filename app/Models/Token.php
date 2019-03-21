<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Token extends Model
{
    protected $table = 'tokens';
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id');
    }

    public function generate($user)
    {
        $this->user_id = $user->id;
        $this->token = uniqid();
        $this->save();

        return $this;
    }
}
