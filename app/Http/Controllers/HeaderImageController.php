<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\HeaderImage;
use Proto\Models\StorageEntry;

class HeaderImageController extends Controller
{
    public function index()
    {
        return view('website.headerimages.index', ['images' => HeaderImage::paginate(5)]);
    }

    public function create()
    {
        return view('website.headerimages.add');
    }

    public function store(Request $request)
    {
        $header = HeaderImage::create([
            'title'     => $request->get('title'),
            'credit_id' => $request->get('user'),
        ]);

        $image = $request->file('image');
        if (!$image) {
            Session::flash('flash_message', 'Image is required.');
            Redirect::back();
        }
        $file = new StorageEntry();
        $file->createFromFile($image);

        $header->image()->associate($file);
        $header->save();

        return Redirect::route('headerimage::index');
    }

    public function destroy($id)
    {
        HeaderImage::findOrFail($id)->delete();
        Session::flash('flash_message', 'Image deleted.');

        return Redirect::route('headerimage::index');
    }
}
