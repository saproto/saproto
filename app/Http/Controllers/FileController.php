<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use Proto\File;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\StorageEntry;

class FileController extends Controller
{
    public function get($id)
    {
        $entry = StorageEntry::find($id);
        $file = Storage::disk('local')->get($entry->filename);
        return (new Response($file, 200))->header('Content-Type', $entry->mime);
    }
}
