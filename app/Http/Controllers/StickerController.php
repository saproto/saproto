<?php

namespace App\Http\Controllers;

use App\Events\StickerPlacedEvent;
use App\Events\StickerRemovedEvent;
use App\Models\Sticker;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class StickerController extends Controller
{
    public function index(): View
    {
        $stickers = Sticker::query()
            ->whereNull('reporter_id')
            ->with('user')
            ->with('image')
            ->get()
            ->map(fn ($item): array => [
                'id' => $item->id,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'user' => $item->user?->calling_name ?? 'Unknown',
                'image' => $item->getImageUrl(),
                'is_owner' => Auth::user()->id === $item->user?->id,
                'date' => $item->created_at->format('d-m-Y'),
            ]);

        return view('stickers.map', ['stickers' => $stickers]);
    }

    public function overviewMap(): View
    {
        $stickers = Sticker::query()
            ->whereNull('reporter_id')
            ->with('user')
            ->get()
            ->map(fn ($item): array => [
                'id' => $item->id,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'user' => $item->user?->calling_name ?? 'Unknown',
            ]);

        return view('stickers.overviewmap', ['stickers' => $stickers]);
    }

    public function create(): void {}

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['required', 'numeric', 'min:-180', 'max:180'],
            'sticker' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'stick_date' => 'required_if:today_checkbox,on|date',
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
            'created_at' => $request->has('today_checkbox') ? now() : $validated['stick_date'],
        ]);

        $sticker->user()->associate(Auth::user());
        $sticker->save();

        if ($request->has('sticker')) {
            try {
                $sticker->addMediaFromRequest('sticker')
                    ->usingFileName('sticker_'.$sticker->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());
                $sticker->delete();

                return Redirect::back();
            }
        }

        StickerPlacedEvent::dispatch($sticker);
        Session::flash('message', 'Sticker added successfully');

        return Redirect::back();
    }

    public function show(Sticker $sticker): void {}

    public function edit(Sticker $sticker): void {}

    public function update(Request $request, Sticker $sticker): void {}

    public function destroy(Sticker $sticker): RedirectResponse
    {
        if (Auth::user()->id != $sticker->user?->id && ! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to delete this sticker');

            return Redirect::back();
        }

        StickerRemovedEvent::dispatch($sticker);

        $sticker->delete();
        $sticker->image->delete();
        Session::flash('flash_message', 'Sticker deleted successfully');

        return Redirect::back();
    }

    public function admin(): View
    {
        $reported = Sticker::query()
            ->with('user')
            ->with('image')
            ->with('reporter')
            ->whereNotNull('reporter_id')
            ->get();

        return view('stickers.admin', ['reported' => $reported]);
    }

    public function report(Request $request, Sticker $sticker): RedirectResponse
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
    }

    public function unreport(Sticker $sticker): RedirectResponse
    {
        $sticker->update([
            'reporter_id' => null,
            'report_reason' => null,
        ]);

        StickerPlacedEvent::dispatch($sticker);

        return Redirect::back()->with('flash_message', 'Sticker succesfully unreported. It will be visible for other users again.');
    }
}
