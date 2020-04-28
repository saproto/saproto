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
            $ord = 'ASC';
            $comp = '>';
        } else {
            $ord = 'DESC';
            $comp = '<';
        }

        $result = Photo::where('album_id', $this->album_id)->where('date_taken', $comp.'=', $this->date_taken)->orderBy('date_taken', $ord)->orderBy('id', $ord);
        if ($result->count() > 1) {
            return $result->where('id', $comp, $this->id)->first();
        }
        return $result->first();
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
