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
use Session;

use Proto\Models\StorageEntry;
use Redirect;

class PhotoAdminController extends Controller
{
    public function index()
    {
        return view('photos.admin.index', ['query' => '']);
    }

    public function search(Request $request)
    {
        return view('photos.admin.index', ['query' => $request->input('query')]);
    }

    public function create(Request $request)
    {
        $album = new PhotoAlbum();
        $album->name = $request->input('name');
        $album->date_taken = strtotime($request->input('date'));
        if ($request->input('private')) {
            $album->private = true;
        }
        $album->save();

        return redirect(route('photo::admin::edit', ['id' => $album->id]));
    }

    public function edit($id)
    {

        $photos = PhotoManager::getPhotos($id);

        if ($photos) return view('photos.admin.edit', ['photos' => $photos]);

        abort(404);
    }

    public function update(Request $request, $id)
    {
        $album = PhotoAlbum::find($id);
        $album->name = $request->input('album');
        $album->date_taken = strtotime($request->input('date'));
        if ($request->input('private')) {
            $album->private = true;
        } else {
            $album->private = false;
        }
        $album->save();
        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    public function upload(Request $request, $id)
    {
        $album = PhotoAlbum::find($id);
        $response = "ERROR";
        if ($request->has('file') && !$album->published) {
            $uploadFile = $request->file('file');

            $photo = $this->createPhotoFromUpload($uploadFile, $id);

            $response = view('website.layouts.macros.selectablephoto', ['photo' => $photo]);
        }
        return $response;
    }

    public function action(Request $request, $id)
    {
        $action = $request->input('submit');
        $photos = $request->input('photo');

        if($photos)
        {
            $album = PhotoAlbum::where('id', $id)->get()->first();

            if ($album->published && !Auth::user()->can('publishalbums')) {
                abort(403, 'Unauthorized action.');
            }


            switch ($action) {
                case "remove":
                    foreach ($photos as $photoId => $photo) {
                        Photo::find($photoId)->delete();
                    }
                    break;

                case "thumbnail":
                    reset($photos);
                    $album->thumb_id = key($photos);
                    break;

                case "private":
                    foreach ($photos as $photoId => $photo) {
                        $photo = Photo::find($photoId);
                        if ($album->published && $photo->private) continue;
                        $photo->private = !$photo->private;
                        $photo->save();
                    }
                    break;
            }
            $album->save();
        }
        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    public function delete($id)
    {
        PhotoManager::deleteAlbum($id);
        return redirect(route('photo::admin::index'));
    }

    public function publish($id)
    {
        $album = PhotoAlbum::where('id', '=', $id)->first();

        if(!count($album->items)>0 || $album->thumb_id == null) {
            Session::flash('flash_message', 'Albums need at least one photo and a thumbnail to be published.');
            return Redirect::back();
        }

        $album->published = true;
        $album->save();
        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    public function unpublish($id)
    {
        $album = PhotoAlbum::where('id', '=', $id)->first();
        $album->published = false;
        $album->save();
        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    private function createPhotoFromUpload($uploadedPhoto, $albumID)
    {
        $path = "photos/" . $albumID . "/";

        $file = new StorageEntry();
        $file->createFromFile($uploadedPhoto, $path);
        $file->save();

        $photo = new Photo();
        $photo->date_taken = $uploadedPhoto->getCTime();
        $photo->album_id = $albumID;
        $photo->file_id = $file->id;
        $photo->save();

        return $photo;
    }
}
