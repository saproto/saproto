<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoAlbum extends Model
{
    public function items()
    {
        return $this->hasMany('Proto\Models\Photo', 'album_id');
    }

    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }

    private function thumbPhoto()
    {
        return $this->hasOne('Proto\Models\Photo', 'id', 'thumb_id');
    }

    public function thumb()
    {
        if ($this->thumb_id) {
            return $this->thumbPhoto()->first()->thumb();
        }
    }
}
