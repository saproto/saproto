<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

use Exception;
use Proto\Http\Controllers\FlickrController;

class Flickr extends Model
{
    public static function getAlbums($max = null)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);

        $base = FlickrAlbum::orderBy('date_taken', 'desc');
        if (!$include_private) {
            $base = $base->where('private', '=', false);
        }
        if ($max != 0) {
            $albums = $base->paginate($max);
        } else {
            $albums = $base->get();
        }
        return $albums;
    }

    public static function getPhotos($albumID, $include_private = false)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);

        $album = FlickrAlbum::where('id', $albumID);
        if (!$include_private) {
            $album->where('private', '=', false);
        }
        $album = $album->get();

        if ($album->count() == 0) {
            abort(404, "This album does not exist.");
        }

        $items = FlickrItem::where('album_id', $albumID);
        if (!$include_private) {
            $items = $items->where('private', '=', false);
        }
        $items = $items->orderBy('date_taken', 'asc')->get();

        $data = new \stdClass();
        $data->album_title = FlickrAlbum::where("id", "=", $albumID)->first()->name;
        $data->album_date = FlickrAlbum::where("id", "=", $albumID)->first()->date_taken;
        $data->event = (FlickrAlbum::where("id", "=", $albumID)->first()->event ? FlickrAlbum::where("id", "=", $albumID)->first()->event : null);
        $data->photos = $items;

        return $data;
    }

    public static function constructAPIUri($method, array $params)
    {
        // Base URI
        $uri = "https://api.flickr.com/services/rest";

        // Token
        $token = FlickrController::getToken();

        // Generate Query String
        $default_params = array(
            'user_id' => urlencode(config('flickr.user')),
            'api_key' => config('flickr.client-id'),
            'format' => 'json',
            'nojsoncallback' => '1',
            'method' => $method,

            // OAuth Parameters
            'oauth_consumer_key' => config('flickr.client-id'),
            'oauth_nonce' => str_random(32),
            'oauth_token' => $token->getIdentifier(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => date('U'),
            'oauth_version' => '1.0'
        );

        $query_string = "";

        $query = array_merge($params, $default_params);
        ksort($query);

        foreach ($query as $key => $value) {
            $query_string .= "&$key=$value";
        }

        $query_string = substr($query_string, 1);

        // Generate Signature
        $sig_base_string = "GET&" . urlencode($uri) . "&" . urlencode($query_string);

        $sig_key = urlencode(config('flickr.client-secret')) . '&' . urlencode($token->getSecret());

        $sig = "oauth_signature=" . base64_encode(hash_hmac('sha1', $sig_base_string, $sig_key, true));

        $return_uri = $uri . '?' . $query_string . '&' . $sig;

        return $return_uri;

    }

    /**
     * Returns Flickr albums
     *
     * @return mixed
     */
    public static function getAlbumsFromAPI($max = null)
    {
        try {

            $albums = json_decode(file_get_contents(Flickr::constructAPIUri('flickr.photosets.getList', array(
                'primary_photo_extras' => 'url_o,url_m'
            ))))->photosets->photoset;

            $data = [];
            foreach (array_slice($albums, 0, $max) as $album) {
                $data[] = (object)[
                    'name' => $album->title->_content,
                    'thumb' => (count($album->primary_photo_extras) > 0 ? $album->primary_photo_extras->url_m : asset('images/logo/inverse.png')),
                    'id' => $album->id,
                    'date_create' => $album->date_create,
                    'date_update' => $album->date_update,
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

        $data = Flickr::getPhotosFromApiPerPage($albumId, 1);

        while ($data->page < $data->pages) {

            $extra_data = Flickr::getPhotosFromApiPerPage($albumId, $data->page + 1);
            $data->page = $extra_data->page;
            $data->photos = array_merge($data->photos, $extra_data->photos);

        }
        
        return $data;

    }

    public static function getPhotosFromApiPerPage($albumId, $page)
    {

        try {

            $photos = json_decode(file_get_contents(Flickr::constructAPIUri('flickr.photosets.getPhotos', array(
                'photoset_id' => $albumId,
                'extras' => 'url_o,url_m,url_l,date_taken',
                'page' => $page
            ))));

            $data = [];

            if ($photos->stat == 'ok') {
                if ($photos->photoset->owner == config('flickr.user')) {
                    foreach ($photos->photoset->photo as $photo) {
                        $p = (object)[
                            'id' => $photo->id,
                            'url' => $photo->url_m,
                            'thumb' => $photo->url_m,
                            'timestamp' => $photo->datetaken,
                            'private' => (boolean)(1 - $photo->ispublic)
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
                'photos' => $data,
                'page' => $photos->photoset->page,
                'pages' => $photos->photoset->pages
            ];

        } catch (Exception $e) {

            return false;

        }

    }

}
