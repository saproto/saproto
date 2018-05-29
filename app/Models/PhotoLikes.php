<?php
namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoLikes extends Model {

    protected $table = 'photo_likes';
    protected $guarded = ['id'];

    public function flickrItem()
    {
        return $this->belongsTo('Proto\Models\FlickrItem', 'photo_id');
    }

}