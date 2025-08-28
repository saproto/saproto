<?php

namespace App\Http\Controllers;

use App\Enums\NarrowcastingEnum;
use App\Models\NarrowcastingItem;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class NarrowcastingController extends Controller
{
    /** @return View */
    public function index()
    {
        $messages = NarrowcastingItem::query()
            ->with(['image', 'media'])
            ->orderBy('campaign_start', 'desc')
            ->paginate(10);

        return view('narrowcasting.list', ['messages' => $messages]);
    }

    /** @return View */
    public function show()
    {
        return view('narrowcasting.show');
    }

    /** @return View */
    public function create()
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
        if (! $request->file('image') && ! $request->has('youtube_id')) {
            Session::flash('flash_message', 'Every campaign needs either an image or a video!');

            return Redirect::back();
        }


        $request->validate([
            'image' => 'nullable|image|max:5120', // max 5MB
        ]);

        $narrowcasting = new NarrowcastingItem;
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

                return Redirect::back();
            }
        }

        $youtube_id = $request->get('youtube_id');

        if ($request->has('youtube_id') && strlen($youtube_id) > 0) {
            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->save();
            $narrowcasting->slide_duration = -1;
        }

        $narrowcasting->save();

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been added.");

        return Redirect::route('narrowcasting::index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id)
    {
        $narrowcasting = NarrowcastingItem::query()->findOrFail($id);

        return view('narrowcasting.edit', ['item' => $narrowcasting]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'image' => 'nullable|image|max:5120', // max 5MB
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

                return Redirect::back();
            }
        }

        $youtube_id = $request->get('youtube_id');

        if ($request->has('youtube_id') && strlen($youtube_id) > 0) {

            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->save();
            $narrowcasting->slide_duration = -1;
        } else {
            $narrowcasting->youtube_id = null;
        }

        $narrowcasting->save();

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been saved.");

        return Redirect::route('narrowcasting::index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(int $id)
    {
        $narrowcasting = NarrowcastingItem::query()->findOrFail($id);

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been deleted.");
        $narrowcasting->delete();

        return Redirect::route('narrowcasting::index');
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

        return Redirect::route('narrowcasting::index');
    }

    /** @return list<array{slide_duration: int, image:string}|array{slide_duration: int, video: non-falsy-string}> Return a JSON object of all currently active campaigns. */
    public function indexApi(): array
    {
        $data = [];
        foreach (
            NarrowcastingItem::query()
                ->where('campaign_start', '<', Carbon::now()->timestamp)
                ->where('campaign_end', '>', Carbon::now()->timestamp)
                ->with('media')
                ->get() as $item) {
            if ($item->youtube_id) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'video' => $item->youtube_id,
                ];
            } elseif ($item->hasMedia()) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'image' => $item->getImageUrl(NarrowcastingEnum::LARGE),
                ];
            }
        }

        return $data;
    }
}
