<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = ['user_id', 'quote'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'quotes_users');
    }

    public function QuoteLike()
    {
        return $this->hasMany('Proto\Models\QuoteLike');
    }

    public function likes()
    {
        $users = array();
        foreach ($this->QuoteLike as $like) {
            $users[] = $like;
        }
        return $users;
    }

    public function liked($user_id)
    {
        foreach ($this->users as $user) {
            if ($user->id == $user_id) {
                return true;
            }
        }
        return false;
    }
}