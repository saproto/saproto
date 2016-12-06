<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrItem extends Model
{
    protected $table = 'flickr_items';

    public $timestamps = false;

    public function album() {
        return $this->belongsTo('Proto\Models\FlickrAlbum', 'flickr_album_id');
    }
}