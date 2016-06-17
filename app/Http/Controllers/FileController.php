<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\StorageEntry;

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
}
