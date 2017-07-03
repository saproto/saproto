<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrAlbum extends Model
{
    protected $table = 'flickr_albums';

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('Proto\Models\FlickrItem', 'album_id');
    }

    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }
}
