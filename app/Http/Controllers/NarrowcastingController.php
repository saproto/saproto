<?php

namespace Proto\Http\Controllers;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\NarrowcastingItem;
use Proto\Models\StorageEntry;
use Redirect;
use Session;
use Youtube;

class NarrowcastingController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('narrowcasting.list', ['messages' => NarrowcastingItem::orderBy('campaign_start', 'desc')->paginate(10)]);
    }

    /** @return View */
    public function display()
    {
        return view('narrowcasting.display');
    }

    /** @return View */
    public function create()
    {
        return view('narrowcasting.edit', ['item' => null]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        if (! $request->file('image') && ! $request->has('youtube_id')) {
            Session::flash('flash_message', 'Every campaign needs either an image or a video!');
            return Redirect::back();
        }

        $narrowcasting = new NarrowcastingItem();
        $narrowcasting->name = $request->name;
        $narrowcasting->campaign_start = strtotime($request->campaign_start);
        $narrowcasting->campaign_end = strtotime($request->campaign_end);
        $narrowcasting->slide_duration = $request->slide_duration;

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $narrowcasting->image()->associate($file);
        }

        $youtube_id = $request->get('youtube_id');

        if ($request->has('youtube_id') && strlen($youtube_id) > 0) {
            $video = Youtube::getVideoInfo($youtube_id);

            /* @phpstan-ignore-next-line */
            if (! $video) {
                Session::flash('flash_message', 'This is an invalid video ID!');
                return Redirect::back();
            }

            if (! $video->status->embeddable) {
                Session::flash('flash_message', 'This video is not embeddable and therefore cannot be used on the site!');
                return Redirect::back();
            }

            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->save();
            $narrowcasting->slide_duration = $narrowcasting->videoDuration();
        }

        $narrowcasting->save();

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been added.");
        return Redirect::route('narrowcasting::list');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $narrowcasting = NarrowcastingItem::findOrFail($id);

        return view('narrowcasting.edit', ['item' => $narrowcasting]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function update(Request $request, $id)
    {
        $narrowcasting = NarrowcastingItem::findOrFail($id);

        $narrowcasting->name = $request->name;
        $narrowcasting->campaign_start = strtotime($request->campaign_start);
        $narrowcasting->campaign_end = strtotime($request->campaign_end);
        $narrowcasting->slide_duration = $request->slide_duration;

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $narrowcasting->image()->associate($file);
        }

        $youtube_id = $request->get('youtube_id');

        if ($request->has('youtube_id') && strlen($youtube_id) > 0) {
            $video = Youtube::getVideoInfo($youtube_id);

            /* @phpstan-ignore-next-line */
            if (! $video) {
                Session::flash('flash_message', 'This is an invalid video ID!');
                return Redirect::back();
            }

            $narrowcasting->youtube_id = $youtube_id;
            $narrowcasting->save();
            $narrowcasting->slide_duration = $narrowcasting->videoDuration();
        } else {
            $narrowcasting->youtube_id = null;
        }

        $narrowcasting->save();

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been saved.");
        return Redirect::route('narrowcasting::list');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $narrowcasting = NarrowcastingItem::findOrFail($id);

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been deleted.");
        $narrowcasting->delete();

        return Redirect::route('narrowcasting::list');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function clear()
    {
        foreach (NarrowcastingItem::where('campaign_end', '<', date('U'))->get() as $item) {
            $item->delete();
        }

        Session::flash('flash_message', 'All finished campaigns have been deleted.');
        return Redirect::route('narrowcasting::list');
    }

    /** @return array Return a JSON object of all currently active campaigns. */
    public function indexApi()
    {
        $data = [];
        foreach (
            NarrowcastingItem::where('campaign_start', '<', date('U'))->where('campaign_end', '>', date('U'))->get() as $item) {
            if ($item->youtube_id) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'video' => $item->youtube_id,
                ];
            } elseif ($item->image) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'image' => $item->image->generateUrl(),
                ];
            }
        }

        return $data;
    }
}
