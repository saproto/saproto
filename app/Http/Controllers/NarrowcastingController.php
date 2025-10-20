<?php

namespace App\Http\Controllers;

use App\Models\NarrowcastingItem;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class NarrowcastingController extends Controller
{
    public function index(): View|Factory
    {
        $messages = NarrowcastingItem::query()
            ->with('media')
            ->orderBy('campaign_start', 'desc')
            ->paginate(10);

        return view('narrowcasting.list', ['messages' => $messages]);
    }

    public function show(): View|Factory
    {
        return view('narrowcasting.show');
    }

    public function create(): View|Factory
    {
        return view('narrowcasting.edit', ['item' => null]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,png,jpg'], // max 5MB
        ]);

        if (! $request->has('image') && ! $request->has('youtube_id')) {
            Session::flash('flash_message', 'Every campaign needs either an image or a video!');

            return back();
        }

        $narrowcasting = new NarrowcastingItem;
        $narrowcasting->name = $request->string('name');
        $narrowcasting->campaign_start = $request->date('campaign_start')->timestamp;
        $narrowcasting->campaign_end = $request->date('campaign_end')->timestamp;
        $narrowcasting->slide_duration = $request->integer('slide_duration');

        $youtube_id = $request->string('youtube_id');

        if ($request->has('youtube_id') && (string) $youtube_id !== '') {
            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->slide_duration = -1;
        }

        $narrowcasting->save();

        if ($request->has('image')) {
            try {
                $narrowcasting->addMediaFromRequest('image')
                    ->usingFileName('narrowcasting_'.$narrowcasting->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return to_route('narrowcasting::edit', ['id' => $narrowcasting->id]);
            }
        }

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been added.");

        return to_route('narrowcasting::edit', ['id' => $narrowcasting->id]);
    }

    public function edit(int $id): View|Factory
    {
        $narrowcasting = NarrowcastingItem::query()->findOrFail($id);

        return view('narrowcasting.edit', ['item' => $narrowcasting]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {

        $request->validate([
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,png,jpg'], // max 5MB
        ]);

        $narrowcasting = NarrowcastingItem::query()->findOrFail($id);

        $narrowcasting->name = $request->name;
        $narrowcasting->campaign_start = $request->date('campaign_start')->timestamp;
        $narrowcasting->campaign_end = $request->date('campaign_end')->timestamp;
        $narrowcasting->slide_duration = $request->slide_duration;

        if ($request->has('image')) {
            try {
                $narrowcasting->addMediaFromRequest('image')
                    ->usingFileName('narrowcasting_'.$narrowcasting->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        }

        $youtube_id = $request->string('youtube_id');
        if ($request->has('youtube_id') && (string) $youtube_id !== '') {

            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->save();
            $narrowcasting->slide_duration = -1;
        } else {
            $narrowcasting->youtube_id = null;
        }

        $narrowcasting->save();

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been saved.");

        return to_route('narrowcasting::edit', ['id' => $narrowcasting->id]);
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy($id)
    {
        $narrowcasting = NarrowcastingItem::query()->findOrFail($id);

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been deleted.");
        $narrowcasting->delete();

        return to_route('narrowcasting::index');
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function clear()
    {
        foreach (NarrowcastingItem::query()->where('campaign_end', '<', Carbon::now()->timestamp)->get() as $item) {
            $item->delete();
        }

        Session::flash('flash_message', 'All finished campaigns have been deleted.');

        return to_route('narrowcasting::index');
    }

    /** @return list<array{slide_duration: int, image:string}|array{slide_duration: int, video: non-falsy-string}> Return a JSON object of all currently active campaigns. */
    public function indexApi(): array
    {
        $data = [];
        foreach (
            NarrowcastingItem::query()->where('campaign_start', '<', Carbon::now()->timestamp)->where('campaign_end', '>', Carbon::now()->timestamp)->get() as $item) {
            if ($item->youtube_id) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'video' => $item->youtube_id,
                ];
            } elseif ($item->hasMedia()) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'image' => $item->getImageUrl(),
                ];
            }
        }

        return $data;
    }
}
