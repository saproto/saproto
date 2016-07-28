<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class PhotoController extends Controller
{
    /**
     * Returns Flickr albums
     *
     * @return mixed
     */
    private function getAlbums() {
        $albums = json_decode(file_get_contents("https://api.flickr.com/services/rest/?method=flickr.photosets.getList&user_id=" . env('FLICKR_USER') . "&format=json&primary_photo_extras=url_o,url_m,date_taken&nojsoncallback=1&api_key=" . env('FLICKR_KEY')))->photosets->photoset;

        return $albums;
    }

    /**
     * Returns photos for given album.
     * Checks whether album is owned by Flickr user.
     *
     * @param $albumId
     * @return null
     */
    private function getPhotos($albumId) {
        $photos = json_decode(file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . env('FLICKR_KEY') . '&photoset_id=' . $albumId . '&format=json&extras=url_o,url_m,url_l&nojsoncallback=1'));

        if($photos->stat == 'ok') {
            if($photos->photoset->owner == env('FLICKR_USER')) {
                return $photos->photoset;
            }
        }

        return null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = $this->getAlbums();

        return view('photos.list', ['albums' => $albums]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photos = $this->getPhotos($id);

        if($photos) return view('photos.album', ['photos' => $photos]);

        abort(404);
    }

    /**
     * Return JSON for a listing of the resource.
     *
     * @return string
     */
    public function apiIndex() {
        $albums = $this->getAlbums();
        return json_encode($albums);
    }

    /**
     * Return JSON for the specified resource.
     *
     * @param $id
     * @return string
     */
    public function apiShow($id) {
        $photos = $this->getPhotos($id);
        return json_encode($photos);
    }

    public function slideshow() {
        return view('photos.slideshow');
    }


}
