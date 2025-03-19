<?php

namespace App\Http\Controllers;

use App\Models\Sticker;
use App\Models\StorageEntry;
use Auth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StickerController extends Controller
{
    public function index()
    {
        $stickers = Sticker::query()->with(['user','image'])->get()->map(function($item){
            return [
                'id' => $item->id,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'user' => $item->user->calling_name,
                'image' => $item->image->generateImagePath(600, 300),
                'is_owner'=>true,
                'date'=>$item->created_at->format('Y-m-d')
            ];
        });

        return view('stickers.map', ['stickers' => $stickers]);
    }

    public function create()
    {
    }

    /**
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['required', 'numeric', 'min:-180', 'max:180'],
            'sticker' => [ 'required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $sticker = new Sticker([
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
        ]);

        $file = new StorageEntry;
        $file->createFromFile($request->file('sticker'));
        $sticker->user()->associate(Auth::user());
        $sticker->image()->associate($file);
        $sticker->save();

        Session::flash('message', 'Sticker added successfully');
        return redirect()->back();
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
