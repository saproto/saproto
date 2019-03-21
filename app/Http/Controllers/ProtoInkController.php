<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\ProtoInk;

use Redirect;

class ProtoInkController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $max = $request->has('max') ? $request->get('max') : null;
        $posts = ProtoInk::getPostsFromFeed($max);

        return json_encode($posts);
    }
}
