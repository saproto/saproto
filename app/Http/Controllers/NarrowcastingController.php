<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\NarrowcastingItem;
use Proto\Models\StorageEntry;
use Redirect;
use Session;
use Youtube;

class NarrowcastingController extends Controller
{
    /**
     * Show an overview of all campaigns.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('narrowcasting.list', ['messages' => NarrowcastingItem::orderBy('campaign_start', 'desc')->paginate(10)]);
    }

    /**
     * Return a JSON object of all currently active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function indexApi()
    {
        $data = [];
        foreach (
            NarrowcastingItem::where('campaign_start', '<', date('U'))->where('campaign_end', '>', date('U'))->get() as $item) {
            if ($item->youtube_id) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'video'          => $item->youtube_id,
                ];
            } elseif ($item->image) {
                $data[] = [
                    'slide_duration' => $item->slide_duration,
                    'image'          => $item->image->generateImagePath(2000, 1200),
                ];
            }
        }

        return $data;
    }

    /**
     * Show the form for creating a new campaign.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('narrowcasting.edit', ['item' => null]);
    }

    /**
     * Store a newly created campaign.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->file('image') && !$request->has('youtube_id')) {
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

            if (!$video) {
                Session::flash('flash_message', 'This is an invalid video ID!');

                return Redirect::back();
            }

            if (!$video->status->embeddable) {
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
     * Show the form for editing the specified campaign.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $narrowcasting = NarrowcastingItem::find($id);

        if ($narrowcasting) {
            return view('narrowcasting.edit', ['item' => $narrowcasting]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified campaign.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $narrowcasting = NarrowcastingItem::find($id);

        if (!$narrowcasting) {
            abort(404);
        }

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

            if (!$video) {
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
     * Remove the specified campaign.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $narrowcasting = NarrowcastingItem::find($id);

        if (!$narrowcasting) {
            abort(404);
        }

        Session::flash('flash_message', "Your campaign '".$narrowcasting->name."' has been deleted.");
        $narrowcasting->delete();

        return Redirect::route('narrowcasting::list');
    }

    public function clear()
    {
        foreach (NarrowcastingItem::where('campaign_end', '<', date('U'))->get() as $item) {
            $item->delete();
        }

        Session::flash('flash_message', 'All finished campaigns have been deleted.');

        return Redirect::route('narrowcasting::list');
    }

    /**
     * Display the public narrowcasting screen.
     *
     * @return mixed
     */
    public function display()
    {
        return view('narrowcasting.display');
    }
}
