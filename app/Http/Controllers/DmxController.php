<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\DmxChannel;
use Proto\Models\DmxFixture;

use Proto\Http\Controllers\CalendarController;

use Session;
use Redirect;

class DmxController extends Controller
{
    public function valueApi()
    {
        // Get the events.
        $events = CalendarController::returnGoogleCalendarEvents(config('proto.smartxp-google-timetable-id'), date('c', strtotime("last week")), date('c', strtotime("tomorrow")));

        // Determine if any event is currently going on.
        $current_event = null;
        foreach ($events as $event) {
            if ($event['current']) {
                $current_event = $event;
            }
        }

        // Determine what preset to use.
        $preset = 'free';
        if (in_array($event['type'], config('dmx.lecture_types'))) {
            $preset = 'lecture';
        } elseif ($current_event !== null) {
            $preset = 'tutorial';
        }

        // Now we fill the preset channels.
        $channel_values = [];
        $preset_colors = config('dmx.colors')[$preset];
        foreach (config('dmx.preset_fixtures') as $fixture_id => $fixture_channel_mapping) {
            $fixture = DmxFixture::where('id', $fixture_id)->first();
            if ($fixture !== null) {
                foreach ($fixture_channel_mapping as $i => $offset) {
                    if ($i < count($preset_colors)) {
                        $channel_values[$fixture->channel_start + $offset] = $preset_colors[$i];
                    }
                }
            }
        }

        return $channel_values;
    }

    public function index()
    {
        return view('dmx.index', ['fixtures' => DmxFixture::orderBy('name', 'asc')->get()]);
    }

    public function create()
    {
        return view('dmx.edit', ['fixture' => null]);
    }

    public function store(Request $request)
    {
        $fixture = DmxFixture::create($request->all());
        $fixture->save();

        Session::flash('flash_message', sprintf('The new fixture %s has been stored.', $fixture->name));
        return Redirect::route('dmx::edit', ['id' => $fixture->id]);
    }

    public function edit($id)
    {
        $fixture = DmxFixture::findOrFail($id);
        return view('dmx.edit', ['fixture' => $fixture]);
    }

    public function update(Request $request, $id)
    {
        $fixture = DmxFixture::findOrFail($id);
        $fixture->fill($request->except('channel_name'));
        $fixture->save();

        foreach ($request->channel_name as $channel_id => $channel_name) {

            $channel = DmxChannel::where('id', $channel_id)->first();

            if ($channel !== null) {
                $channel->name = $channel_name;
            } else {
                $channel = DmxChannel::create(['id' => $channel_id, 'name' => $channel_name]);
            }

            $channel->save();

        }

        Session::flash('flash_message', sprintf('The fixture %s has been updated.', $fixture->name));
        return Redirect::back();
    }

    public function delete($id)
    {
        $fixture = DmxFixture::findOrFail($id);
        Session::flash('flash_message', sprintf('The fixture %s has been deleted.', $fixture->name));
        $fixture->delete();

        return Redirect::route('dmx::index');
    }
}
