<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\StorageEntry;

use Image;

class FileController extends Controller
{

    public function get($id, $hash)
    {

        $entry = StorageEntry::find($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $file = Storage::disk('local')->get($entry->filename);

        $response = new Response($file, 200);
        $response->header('Content-Type', $entry->mime);

        return $response;

    }

    public function getImage($id, $hash, Request $request)
    {

        $entry = StorageEntry::find($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $storage = config('filesystems.disks');

        $opts = [
            'w' => ($request->has('w') ? $request->input('w') : null),
            'h' => ($request->has('h') ? $request->input('h') : null)
        ];

        ini_set('memory_limit', '256M');

        $img = Image::cache(function ($image) use ($storage, $entry, $opts) {
            if ($opts['w'] && $opts['h']) {
                $image->make($storage['local']['root'] . '/' . $entry->filename)->fit($opts['w'], $opts['h'], function ($constraint) {
                    $constraint->upsize();
                });
            } elseif($opts['w'] || $opts['h']) {
                $image->make($storage['local']['root'] . '/' . $entry->filename)->resize($opts['w'], $opts['h'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $image->make($storage['local']['root'] . '/' . $entry->filename);
            }
        });

        $response = new Response($img, 200);
        $response->header('Content-Type', $entry->mime);

        return $response;

    }

}
