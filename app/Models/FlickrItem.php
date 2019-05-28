<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class FlickrItem extends Model
{
    protected $table = 'flickr_items';
    protected $primaryKey = 'id';
    public $incrementing = false;

    public $timestamps = false;

    public function album()
    {
        return $this->belongsTo('Proto\Models\FlickrAlbum', 'album_id');
    }

    private function getAdjacentPhoto($next = true)
    {
        $result = FlickrItem::where('album_id', $this->album_id)->orderBy('date_taken', 'asc')->orderBy('id', 'asc')->get()->pluck('id')->toArray();
        $index = array_search($this->id, $result);

        if (($next == false && $index == 0) || ($next == true && $index > (count($result) - 1))) {
            return null;
        } else {
            $adjacentIndex = $index + ($next ? 1 : -1);
            return FlickrItem::where('id', $result[$adjacentIndex])->first();
        }
    }

    public function getNextPhoto()
    {
        return $this->getAdjacentPhoto();
    }

    public function getPreviousPhoto()
    {
        return $this->getAdjacentPhoto(false);
    }

    public function getLikes()
    {
        return PhotoLikes::where("photo_id", "=", $this->id)->count();
    }
}