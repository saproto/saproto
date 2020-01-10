<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Photo extends Model
{

    protected $appends = ['url'];

    public function album() {
        return $this->belongsTo('Proto\Models\PhotoAlbum', 'album_id');
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

        $result = DB::select(DB::raw(sprintf("SELECT id FROM photos WHERE album_id = %s AND date_taken = (SELECT %s(date_taken) FROM flickr_items WHERE date_taken %s %s)", $this->album_id, $func, $comp, $this->date_taken)));
        if (count($result) > 0) {
            $id = $result[0]->id;
            return Photo::where('id', $id)->first();
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

    public function getLikes()
    {
        return $this->likes()->count();
    }

    public function likes() {
        return $this->hasMany('Proto\Models\PhotoLikes');
    }

    private function file() {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'file_id');
    }

    public function thumb() {
        return $this->file()->first()->generateImagePath(400,400);
    }

    public function url() {
        return $this->file()->first()->generatePath();
    }

    public function getUrlAttribute() {
        return $this->url();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($photo) {
            $photo->file()->delete();
        });
    }
}
