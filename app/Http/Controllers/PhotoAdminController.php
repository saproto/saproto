<?php

namespace Proto\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\StorageEntry;
use Redirect;
use Session;

class PhotoAdminController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('photos.admin.index');
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
        $album = PhotoAlbum::findOrFail($id);
        $photos = $album->items()->get();

        if ($photos) {
            return view('photos.admin.edit', ['album'=>$album, 'photos' => $photos]);
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
        $album->private = $request->has('private');
        foreach ($album->items as $photo){
            $photo->private = $request->has('private');
            $photo->save();
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
            $addWaterMark = $request->has('addWaterMark');

            $photo = $this->createPhotoFromUpload($uploadFile, $id, $addWaterMark);
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
        $album = PhotoAlbum::findOrFail($id);
        $album->delete();
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
    private function createPhotoFromUpload($uploaded_photo, $album_id, $addWatermark = false)
    {
        $album = PhotoAlbum::findOrFail($album_id);
        $original_photo_storage = 'photos/original_photos/'.$album_id.'/';
        $large_photos_storage = 'photos/large_photos/'.$album_id.'/';
        $medium_photos_storage = 'photos/medium_photos/'.$album_id.'/';
        $small_photos_storage = 'photos/small_photos/'.$album_id.'/';
        $tiny_photos_storage = 'photos/tiny_photos/'.$album_id.'/';

        $watermark = null;
        if($addWatermark) {
            $watermark = Image::make(public_path('images/protography-watermark-template.png'));
            $watermark->text(strtoupper(Auth::user()->name), 267, 1443, function ($font) {
                $font->file((public_path('fonts/ubuntu-font-family-0.83/Ubuntu-R.ttf')));
                $font->size(180);
                $font->valign('top');
            });
        }

        $original_file = new StorageEntry();
        $original_file->createFromPhoto($uploaded_photo, $original_photo_storage, null, $uploaded_photo->getClientOriginalName(), $watermark, $album->private);
        $original_file->save();

        $large_file = new StorageEntry();
        $large_file->createFromPhoto($uploaded_photo, $large_photos_storage, 1080, $uploaded_photo->getClientOriginalName(), $watermark, $album->private);
        $large_file->save();

        $medium_file = new StorageEntry();
        $medium_file->createFromPhoto($uploaded_photo, $medium_photos_storage, 750, $uploaded_photo->getClientOriginalName(), $watermark, $album->private);
        $medium_file->save();

        $small_file = new StorageEntry();
        $small_file->createFromPhoto($uploaded_photo, $small_photos_storage,420, $uploaded_photo->getClientOriginalName(), $watermark, $album->private);
        $small_file->save();

        $tiny_file = new StorageEntry();
        $tiny_file->createFromPhoto($uploaded_photo, $tiny_photos_storage,20, $uploaded_photo->getClientOriginalName(), $watermark, $album->private);
        $tiny_file->save();

        $photo = new Photo();
        $photo->date_taken = $uploaded_photo->getCTime();
        $photo->album_id = $album_id;
        $photo->file_id = $original_file->id;
        $photo->large_file_id = $large_file->id;
        $photo->medium_file_id = $medium_file->id;
        $photo->small_file_id = $small_file->id;
        $photo->tiny_file_id = $tiny_file->id;
        $photo->private = $album->private;
        $photo->save();

        return $photo;
    }
}
