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
        if ($next) {
            $func = 'MIN';
            $comp = '>';
        } else {
            $func = 'MAX';
            $comp = '<';
        }

        $result = DB::select(DB::raw(sprintf("SELECT id FROM flickr_items WHERE album_id = %s AND date_taken = (SELECT %s(date_taken) FROM flickr_items WHERE date_taken %s %s)", $this->album_id, $func, $comp, $this->date_taken)));
        if (count($result) > 0) {
            $id = $result[0]->id;
            return FlickrItem::where('id', $id)->first();
        } else {
            return null;
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
}