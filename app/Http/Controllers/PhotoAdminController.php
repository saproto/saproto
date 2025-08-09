<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PhotoAdminController extends Controller
{
    /** @return View */
    public function index(Request $request)
    {
        $name = $request->input('query');
        $published = PhotoAlbum::query()->where('published', true)->orderBy('date_taken', 'desc');
        $unpublished = PhotoAlbum::query()->where('published', false)->orderBy('date_taken', 'desc');

        if ($name) {
            $published = $published->name($name);
            $unpublished = $unpublished->name($name);
        }

        return view('photos.admin.index', ['query' => $name, 'published' => $published->get(), 'unpublished' => $unpublished->get()]);
    }

    /**
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        $album = new PhotoAlbum;
        $album->name = $request->input('name');
        $album->date_taken = $request->date('date')->timestamp;
        if ($request->input('private')) {
            $album->private = true;
        }

        $album->save();

        return Redirect::route('albums::admin::edit', ['id' => $album->id]);
    }

    /**
     * @return View
     */
    public function edit(int $id)
    {
        $album = PhotoAlbum::query()
            ->with([
                'items',
                'event'])
            ->findOrFail($id);

        $fileSizeLimit = ini_get('post_max_size');

        return view('photos.admin.edit', ['album' => $album, 'fileSizeLimit' => $fileSizeLimit]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $album = PhotoAlbum::query()
            ->findOrFail($id);

        $album->name = $request->input('album');
        $album->date_taken = $request->date('date')->timestamp;
        $album->save();

        return Redirect::route('albums::admin::edit', ['id' => $id]);
    }

    /**
     * @return JsonResponse|string
     */
    public function upload(Request $request, int $id)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // max 5MB
            'date' => 'nullable|date',
        ]);

        $album = PhotoAlbum::query()->findOrFail($id);

        if ($album->published) {
            return response()->json([
                'message' => 'album already published! Unpublish to add more photos!',
            ], 500);
        }

        $date = $request->file('file')->getCTime();
        if ($request->has('date')) {
            $date = $request->date('date')->timestamp;
        }

        $photo = Photo::query()->create([
            'date_taken' => $date,
            'album_id' => $album->id,
            'private' => $album->private,
            'file_id' => 1,
        ]);

        try {
            $photo->addMediaFromRequest('file')
                ->usingFileName($album->id.'_'.$photo->id)
                ->toMediaCollection($album->private ? 'private' : 'public');

            return html_entity_decode(view('photos.includes.selectablephoto', ['photo' => $photo]));
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function action(Request $request, int $id)
    {
        $action = $request->input('action');
        $photos = $request->input('photos');

        if ($photos) {
            $album = PhotoAlbum::query()->findOrFail($id);

            if ($album->published && ! Auth::user()->can('publishalbums')) {
                abort(403, 'Unauthorized action.');
            }

            switch ($action) {
                case 'remove':
                    foreach ($photos as $photoId) {
                        if($album->published  && (int)$photoId === $album->thumb_id){
                            Session::flash('flash_message', 'You can not remove the thumbnail of a published album!');
                            continue;
                        }

                        Photo::query()->find($photoId)->delete();
                    }

                    break;

                case 'thumbnail':
                    $album->thumb_id = (int) $photos[0];
                    break;

                case 'private':
                    if ($album->private) {
                        Session::flash('flash_message', 'You can not set photos to public in a private album.');
                        break;
                    }

                    foreach ($photos as $photoId) {
                        $photo = Photo::query()->find($photoId);
                        if ($album->published && $photo->private) {
                            continue;
                        }

                        $media = $photo->getFirstMedia('*');
                        $media->move($photo, $photo->private ? 'public' : 'private');

                        $photo->update([
                            'private' => ! $photo->private,
                        ]);
                    }

                    break;
            }

            $album->save();
        }

        return Redirect::route('albums::admin::edit', ['id' => $id]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function delete(int $id)
    {
        $album = PhotoAlbum::query()->findOrFail($id);
        $album->items->each->delete();
        $album->delete();

        return Redirect::route('albums::admin::index');
    }

    /**
     * @return RedirectResponse
     */
    public function publish(int $id)
    {
        $album = PhotoAlbum::query()->where('id', $id)->first();

        if (! $album->items()->exists() || $album->thumb_id === null) {
            Session::flash('flash_message', 'Albums need at least one photo and a thumbnail to be published.');

            return Redirect::back();
        }

        $album->published = true;
        $album->save();

        return Redirect::route('albums::admin::edit', ['id' => $id]);
    }

    /**
     * @return RedirectResponse
     */
    public function unpublish(int $id)
    {
        $album = PhotoAlbum::query()->where('id', $id)->first();
        $album->published = false;
        $album->save();

        return Redirect::route('albums::admin::edit', ['id' => $id]);
    }
}
