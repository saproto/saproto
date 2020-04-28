<?php
namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrLikes extends Model {

    protected $table = 'flickr_likes';
    protected $guarded = ['id'];

    public function flickrItem()
    {
        return $this->belongsTo('Proto\Models\FlickrItem', 'photo_id');
    }

}