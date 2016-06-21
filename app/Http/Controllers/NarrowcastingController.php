<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Auth;
use Session;
use Redirect;

use Proto\Models\Committee;
use Proto\Models\NarrowcastingItem;
use Proto\Models\StorageEntry;

class NarrowcastingController extends Controller
{
    /**
     * Show an overview of all campaigns.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('narrowcasting.list', ['messages' => NarrowcastingItem::get()]);
    }

    /**
     * Return a JSON object of all currently active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function indexApi()
    {
        $data = [];
        foreach (NarrowcastingItem::where('campaign_start', '<', date('U'))->where('campaign_end', '>', date('U'))->get() as $item) {
            $data[] = [
                'slide_duration' => $item->slide_duration,
                'image' => $item->image->generateImagePath(2000, 1200)
            ];
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!$request->file('image')) {
            Session::flash("flash_message", "Every campaign needs an image. Really!");
            return Redirect::back();
        }

        $narrowcasting = new NarrowcastingItem();
        $narrowcasting->name = $request->name;
        $narrowcasting->campaign_start = strtotime($request->campaign_start);
        $narrowcasting->campaign_end = strtotime($request->campaign_end);
        $narrowcasting->slide_duration = $request->slide_duration;

        $file = new StorageEntry();
        $file->createFromFile($request->file('image'));

        $narrowcasting->image()->associate($file);

        $narrowcasting->save();

        Session::flash("flash_message", "Your campaign '" . $narrowcasting->name . "' has been added.");
        return Redirect::route('narrowcasting::list');

    }

    /**
     * Show the form for editing the specified campaign.
     *
     * @param  int $id
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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
            $file->createFrom($request->file('image'));

            $narrowcasting->image()->associate($file);
        }

        $narrowcasting->save();

        Session::flash("flash_message", "Your campaign '" . $narrowcasting->name . "' has been saved.");
        return Redirect::route('narrowcasting::list');

    }

    /**
     * Remove the specified campaign.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $narrowcasting = NarrowcastingItem::find($id);

        if (!$narrowcasting) {
            abort(404);
        }

        Session::flash("flash_message", "Your campaign '" . $narrowcasting->name . "' has been deleted.");
        $narrowcasting->delete();
        return Redirect::route('narrowcasting::list');

    }

    public function clear()
    {

        foreach (NarrowcastingItem::where('campaign_end', '<', date('U'))->get() as $item) {
            $item->delete();
        }

        Session::flash("flash_message", "All finished campaigns have been deleted.");
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
