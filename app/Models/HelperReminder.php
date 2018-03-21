<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class HelperReminder extends Model
{
    protected $table = 'committees_helper_reminders';
    public $timestamps = false;
    public $fillable = ['user_id', 'committee_id'];

    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
