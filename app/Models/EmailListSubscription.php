<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class EmailListSubscription extends Model
{

    protected $table = 'users_mailinglists';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne('Proto\Models\User');
    }

    public function emaillist()
    {
        return $this->belongsTo('Proto\Models\EmailList', 'list_id');
    }

}
