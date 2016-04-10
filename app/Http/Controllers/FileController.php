<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\File;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class FileController extends Controller
{
    public function get($id)
    {
        $entry = File::find($id)->first();
        $file = Storage::disk('local')->get($entry->filename);
        return (new Response($file, 200))->header('Content-Type', $entry->mime);
    }
}
