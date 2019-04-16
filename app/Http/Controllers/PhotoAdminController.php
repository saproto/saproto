<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Photo;
use Proto\Models\PhotoManager;
use Proto\Models\PhotoAlbum;
use Proto\Models\PhotoLikes;
use Auth;

use Proto\Models\StorageEntry;
use Redirect;

class PhotoAdminController extends Controller
{
    public function index() {
        return view('photos.admin.index', ['query' => '']);
    }

    public function search(Request $request) {
        return view('photos.admin.index', ['query' => $request->input('query')]);
    }

    public function create(Request $request) {
        $album = new PhotoAlbum();
        $album->name = $request->input('name');
        $album->date_taken = strtotime($request->input('date'));
        if ($request->input('private')) {
            $album->private = True;
        }
        $album->save();

        return redirect(route('photo::admin::edit', ['id' => $album->id]));
    }

    public function edit($id) {

        $photos = PhotoManager::getPhotos($id);

        if ($photos) return view('photos.admin.edit', ['photos' => $photos]);

        abort(404);
    }

    public function setThumb(Request $request, $id) {
        if($request->has('photoid')) {

        }
    }

    public function upload(Request $request, $id) {
        $response = "ERROR";
        if($request->has('file')) {
            $uploadFile = $request->file('file');

            $file = new StorageEntry();
            $file->createFromFile($uploadFile);
            $file->save();

            $photo = new Photo();
            $photo->date_taken = $uploadFile->getCTime();
            $photo->album_id = $id;
            $photo->file_id = $file->id;
            $photo->save();
            $response = $photo->thumb();
        }
        return $response;
    }

    public function publish($id) {
        $album = PhotoAlbum::where('id', '=', $id)->first();
        $album->published = true;
        $album->save();
        return redirect(route('photo::admin::edit', ['id' => $id]));
    }
}
