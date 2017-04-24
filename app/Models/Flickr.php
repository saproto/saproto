<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Exception;

class Flickr extends Model
{
    public static function getAlbums($max = null, $private = false)
    {
        if ($private) {
            $albums = ($max == null) ? FlickrAlbum::orderBy('date_taken', 'desc')->get() : $albums = FlickrAlbum::orderBy('date_taken', 'desc')->paginate($max);
        } else {
            $albums = ($max == null) ? FlickrAlbum::where('private', false)->orderBy('date_taken', 'desc')->get() : $albums = FlickrAlbum::where('private', false)->orderBy('date_taken', 'desc')->paginate($max);
        }
        return $albums;
    }

    public static function getPhotos($albumID)
    {
        $items = FlickrItem::where("album_id", "=", $albumID)->orderBy('date_taken', 'asc')->get();
        if (count($items) == 0) abort(404, "Album not found.");

        $data = new \stdClass();
        $data->album_title = FlickrAlbum::where("id", "=", $albumID)->first()->name;
        $data->album_date = FlickrAlbum::where("id", "=", $albumID)->first()->date_taken;
        $data->event = (FlickrAlbum::where("id", "=", $albumID)->first()->event ? FlickrAlbum::where("id", "=", $albumID)->first()->event : null);
        $data->photos = $items;

        return $data;
    }


    /**
     * Returns Flickr albums
     *
     * @return mixed
     */
    public static function getAlbumsFromAPI($max = null)
    {
        try {

            $albums = json_decode(file_get_contents("https://api.flickr.com/services/rest/?method=flickr.photosets.getList&user_id=" . env('FLICKR_USER') . "&format=json&primary_photo_extras=url_o,url_m&nojsoncallback=1&api_key=" . env('FLICKR_KEY')))->photosets->photoset;

            $data = [];
            foreach (array_slice($albums, 0, $max) as $album) {
                $data[] = (object)[
                    'name' => $album->title->_content,
                    'thumb' => $album->primary_photo_extras->url_m,
                    'id' => $album->id,
                    'date_create' => $album->date_create,
                    'date_update' => $album->date_update
                ];
            }
            return $data;

        } catch (Exception $e) {

            return false;

        }

    }

    /**
     * Returns photos for given album.
     * Checks whether album is owned by Flickr user.
     *
     * @param $albumId
     * @return null
     */
    public static function getPhotosFromAPI($albumId)
    {
        try {

            $photos = json_decode(file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . env('FLICKR_KEY') . '&photoset_id=' . $albumId . '&format=json&extras=url_o,url_m,url_l,date_taken&nojsoncallback=1'));
            $data = [];

            if ($photos->stat == 'ok') {
                if ($photos->photoset->owner == env('FLICKR_USER')) {
                    foreach ($photos->photoset->photo as $photo) {
                        $p = (object)[
                            'id' => $photo->id,
                            'url' => $photo->url_m,
                            'thumb' => $photo->url_m,
                            'timestamp' => $photo->datetaken
                        ];
                        if (property_exists($photo, 'url_l')) {
                            $p->url = $photo->url_l;
                        } elseif (property_exists($photo, 'url_o')) {
                            $p->url = $photo->url_o;
                        }
                        $data[] = $p;
                    }
                }
            }

            return (object)[
                'album_title' => $photos->photoset->title,
                'photos' => $data
            ];

        } catch (Exception $e) {

            return false;

        }
    }

}
