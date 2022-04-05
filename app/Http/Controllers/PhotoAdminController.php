<?php

namespace Proto\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\PhotoManager;
use Proto\Models\StorageEntry;
use Redirect;
use Session;

class PhotoAdminController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('photos.admin.index', ['query' => '']);
    }

    /** @return View */
    public function search(Request $request)
    {
        return view('photos.admin.index', ['query' => $request->input('query')]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
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

    /**
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $photos = PhotoManager::getPhotos($id);

        if ($photos) {
            return view('photos.admin.edit', ['photos' => $photos]);
        }

        abort(404);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
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

    /**
     * @param Request $request
     * @param int $id
     * @return false|string
     * @throws FileNotFoundException
     */
    public function upload(Request $request, $id)
    {
        $album = PhotoAlbum::findOrFail($id);

        if (! $request->hasFile('file')){return response()->json([
            'message'=>'photo not found in request!',
        ], 404);
        }
        elseif ($album->published){return response()->json([
            'message'=>'album already published! Unpublish to add more photos!',
        ], 500);
        }
            try{
            $uploadFile = $request->file('file');

            $photo = $this->createPhotoFromUpload($uploadFile, $id);
            return html_entity_decode(view('website.layouts.macros.selectablephoto', ['photo' => $photo]));
            }catch (Exception $e) {
                return response()->json([
                    'message'=>$e,
                ], 500);
            }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function action(Request $request, $id)
    {
        $action = $request->input('action');
        $photos = $request->input('photo');

        if ($photos) {
            $album = PhotoAlbum::where('id', $id)->get()->first();

            if ($album->published && ! Auth::user()->can('publishalbums')) {
                abort(403, 'Unauthorized action.');
            }

            switch ($action) {
                case 'remove':
                    foreach ($photos as $photoId => $photo) {
                        Photo::find($photoId)->delete();
                    }
                    break;

                case 'thumbnail':
                    reset($photos);
                    $album->thumb_id = key($photos);
                    break;

                case 'private':
                    foreach ($photos as $photoId => $photo) {
                        $photo = Photo::find($photoId);
                        if ($album->published && $photo->private) {
                            continue;
                        }
                        $photo->private = ! $photo->private;
                        $photo->save();
                    }
                    break;
            }
            $album->save();
        }

        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id)
    {
        PhotoManager::deleteAlbum($id);
        return redirect(route('photo::admin::index'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function publish($id)
    {
        $album = PhotoAlbum::where('id', '=', $id)->first();

        if (! count($album->items) > 0 || $album->thumb_id == null) {
            Session::flash('flash_message', 'Albums need at least one photo and a thumbnail to be published.');

            return Redirect::back();
        }

        $album->published = true;
        $album->save();

        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function unpublish($id)
    {
        $album = PhotoAlbum::where('id', '=', $id)->first();
        $album->published = false;
        $album->save();

        return redirect(route('photo::admin::edit', ['id' => $id]));
    }

    /**
     * @param UploadedFile $uploaded_photo
     * @param int $album_id
     * @return Photo
     * @throws FileNotFoundException
     */
    private function createPhotoFromUpload($uploaded_photo, $album_id)
    {
        $path = 'photos/'.$album_id.'/';

        $file = new StorageEntry();
        $file->createFromFile($uploaded_photo, $path);
        $file->save();

        $photo = new Photo();
        $photo->date_taken = $uploaded_photo->getCTime();
        $photo->album_id = $album_id;
        $photo->file_id = $file->id;
        $photo->save();

        return $photo;
    }
}
