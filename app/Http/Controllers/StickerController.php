<?php

namespace App\Http\Controllers;

use App\Events\StickerPlacedEvent;
use App\Events\StickerRemovedEvent;
use App\Models\Sticker;
use App\Models\StorageEntry;
use Auth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StickerController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function index()
    {
        $stickers = Sticker::query()
            ->whereNull('reporter_id')
            ->with(['user', 'image'])->get()->map(fn ($item): array => [
                'id' => $item->id,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'user' => $item->user?->calling_name ?? 'Unknown',
                'image' => $item->image->generateImagePath(null, null),
                'is_owner' => Auth::user()->id === $item->user?->id,
                'date' => $item->created_at->format('d-m-Y'),
            ]);

        return view('stickers.map', ['stickers' => $stickers]);
    }

    public function overviewMap()
    {
        $stickers = Sticker::query()
            ->whereNull('reporter_id')
            ->with(['user'])->get()->map(fn ($item): array => [
                'id' => $item->id,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'user' => $item->user?->calling_name??'Unknown',
            ]);

        return view('stickers.overviewmap', ['stickers' => $stickers]);
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

        $lat = number_format((float) $validated['lat'], 4, '.', '');
        $lng = number_format((float) $validated['lng'], 4, '.', '');
        $addressInfo = Cache::rememberForever("stickers-{$lat}-{$lng}", fn () => Http::timeout(10)->connectTimeout(5)->withUserAgent('S.A. Proto')
            ->get(Config::string('proto.geoprovider')."/reverse?lat={$lat}&lon={$lng}&accept-language=en&format=json&zoom=13")->json('address'));

        $sticker = new Sticker([
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'city' => $addressInfo['city'] ?? $addressInfo['town'] ?? $addressInfo['village'] ?? null,
            'country' => $addressInfo['country'] ?? null,
            'country_code' => $addressInfo['country_code'] ?? null,
        ]);

        $file = new StorageEntry;
        $file->createFromFile($request->file('sticker'));
        $sticker->user()->associate(Auth::user());
        $sticker->image()->associate($file);
        $sticker->save();

        StickerPlacedEvent::dispatch($sticker);
        Session::flash('message', 'Sticker added successfully');

        return Redirect::back();
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy(Sticker $sticker)
    {
        if (Auth::user()->id != $sticker->user->id && ! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to delete this sticker');

            return Redirect::back();
        }

        StickerRemovedEvent::dispatch($sticker);

        $sticker->delete();
        $sticker->image->delete();
        Session::flash('flash_message', 'Sticker deleted successfully');

        return Redirect::back();
    }

    public function admin(){
        $reported = Sticker::query()->with(['user', 'image', 'reporter'])->whereNotNull('reporter_id')->get();
        return view('stickers.admin', ['reported'=>$reported]);
    }

    public function report(Request $request, Sticker $sticker)
    {
        $validated = $request->validate([
            'report_reason' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $sticker->update([
            'reporter_id' => Auth::user()->id,
            'report_reason' => $validated['report_reason'],
        ]);

        StickerRemovedEvent::dispatch($sticker);

        return Redirect::back()->with('flash_message', 'Sticker reported successfully. It will not be visible for other users until the board has reviewed it.');
        // todo: send an email to alert the board, and the user that the sticker is reported from
    }

    public function unreport(Sticker $sticker)
    {
        $sticker->update([
            'reporter_id' => null,
            'report_reason' => null,
        ]);

        StickerPlacedEvent::dispatch($sticker);

        return Redirect::back()->with('flash_message', 'Sticker succesfully unreported. It will be visible for other users again.');
    }
}
