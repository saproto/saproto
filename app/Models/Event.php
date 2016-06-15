<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * @return mixed The activity associated with this event, if any.
     */
    public function activity() {
        return $this->hasOne('Proto\Models\Activity');
    }

    /**
     * @return mixed The image associated with this event, if any.
     */
    public function image() {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }

    protected $guarded = ['id'];
    
}
