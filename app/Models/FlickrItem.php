<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrItem extends Model
{
    protected $table = 'flickr_items';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function album() {
        return $this->belongsTo('Proto\Models\FlickrAlbum', 'album_id');
    }
}