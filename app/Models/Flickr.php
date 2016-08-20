<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Flickr extends Model
{

    /**
     * Returns Flickr albums
     *
     * @return mixed
     */
    public static function getAlbums($max = null) {
        $albums = json_decode(file_get_contents("https://api.flickr.com/services/rest/?method=flickr.photosets.getList&user_id=" . env('FLICKR_USER') . "&format=json&primary_photo_extras=url_o,url_m,date_taken&nojsoncallback=1&api_key=" . env('FLICKR_KEY')))->photosets->photoset;
        return array_slice($albums, 0, $max);
    }

    /**
     * Returns photos for given album.
     * Checks whether album is owned by Flickr user.
     *
     * @param $albumId
     * @return null
     */
    public static function getPhotos($albumId) {
        $photos = json_decode(file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . env('FLICKR_KEY') . '&photoset_id=' . $albumId . '&format=json&extras=url_o,url_m,url_l&nojsoncallback=1'));
        if($photos->stat == 'ok') {
            if($photos->photoset->owner == env('FLICKR_USER')) {
                return $photos->photoset;
            }
        }

        return null;
    }

}
