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
                'items' => function ($query) {
                    $query->orderBy('date_taken', 'desc');
                },
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
        $album = PhotoAlbum::query()->findOrFail($id);
        $album->name = $request->input('album');
        $album->date_taken = $request->date('date')->timestamp;
        $album->private = (bool) $request->input('private');
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
        ]);

        $album = PhotoAlbum::query()->findOrFail($id);

        if ($album->published) {
            return response()->json([
                'message' => 'album already published! Unpublish to add more photos!',
            ], 500);
        }

        $photo = Photo::query()->create([
            'date_taken' => $request->file('file')->getCTime(),
            'album_id' => $album->id,
            'private' => $album->private,
            'file_id' => 1,
        ]);

        $disk = $album->private ? 'local' : 'public';
        try {
            $photo->addMediaFromRequest('file')
                ->usingFileName($album->id.'_'.$photo->id)
                ->toMediaCollection(diskName: $disk);

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
                        Photo::query()->find($photoId)->delete();
                    }

                    break;

                case 'thumbnail':
                    $album->thumb_id = (int) $photos[0];
                    break;

                case 'private':
                    foreach ($photos as $photoId) {
                        $photo = Photo::query()->find($photoId);
                        if ($album->published && $photo->private) {
                            continue;
                        }

                        $media = $photo->getFirstMedia();
                        $media->move($photo, diskName: $photo->private ? 'public' : 'local');

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
