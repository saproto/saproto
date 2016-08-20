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

        $entry = StorageEntry::findOrFail($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $file = Storage::disk('local')->get($entry->filename);

        $response = new Response($file, 200);
        $response->header('Content-Type', $entry->mime);

        return $response;

    }

    public static function makeImage(StorageEntry $entry, $w, $h)
    {

        $storage = config('filesystems.disks');

        $opts = [
            'w' => $w,
            'h' => $h
        ];

        ini_set('memory_limit', '256M');

        return Image::cache(function ($image) use ($storage, $entry, $opts) {
            if ($opts['w'] && $opts['h']) {
                $image->make($storage['local']['root'] . '/' . $entry->filename)->fit($opts['w'], $opts['h'], function ($constraint) {
                    $constraint->upsize();
                });
            } elseif ($opts['w'] || $opts['h']) {
                $image->make($storage['local']['root'] . '/' . $entry->filename)->resize($opts['w'], $opts['h'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $image->make($storage['local']['root'] . '/' . $entry->filename);
            }
        });

    }

    public function getImage($id, $hash, Request $request)
    {

        $entry = StorageEntry::findOrFail($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $response = new Response($this->makeImage(
            $entry,
            ($request->has('w') ? $request->input('w') : null),
            ($request->has('h') ? $request->input('h') : null)
        ), 200);
        $response->header('Content-Type', $entry->mime);

        return $response;

    }

    /**
     * This static function sends a print request to
     */
    public static function requestPrint($printer, $url, $copies = 1)
    {

        $payload = base64_encode(json_encode((object)[
            'secret' => env('PRINTER_SECRET'),
            'url' => $url,
            'printer' => $printer,
            'copies' => $copies
        ]));

        $result = null;
        try {
            $result = file_get_contents('http://' . env('PRINTER_HOST') . ':' . env('PRINTER_PORT') . '/?data=' . $payload);
        } catch (\Exception $e) {
            return "Exception while connecting to the printer server: " . $e->getMessage();
        }
        return ($result !== false ? $result : "Something went wrong while connecting to the printer server.");

    }

}
