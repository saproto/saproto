<?php

namespace App\Http\Controllers;

use App\Models\Sticker;
use App\Models\StorageEntry;
use Auth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StickerController extends Controller
{
    public function index()
    {
        $stickers = Sticker::query()->with(['user', 'image'])->get()->map(fn ($item): array => [
            'id' => $item->id,
            'lat' => $item->lat,
            'lng' => $item->lng,
            'user' => $item->user->calling_name,
            'image' => $item->image->generateImagePath(600, 300),
            'is_owner' => Auth::user()->id == $item->user->id,
            'date' => $item->created_at->format('Y-m-d'),
        ]);

        return view('stickers.map', ['stickers' => $stickers]);
    }

    public function create() {}

    /**
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['required', 'numeric', 'min:-180', 'max:180'],
            'sticker' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
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

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id)
    {
        $sticker = Sticker::query()->findorFail($id);
        $sticker->delete();
        $sticker->image->delete();
        Session::flash('flash_message', 'Sticker deleted successfully');

        return Redirect::route('stickers.index');
    }
}
