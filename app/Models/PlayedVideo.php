<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class PlayedVideo extends Model
{
    protected $table = 'playedvideos';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
