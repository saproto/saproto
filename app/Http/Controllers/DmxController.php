<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\DmxChannel;
use Proto\Models\DmxFixture;

use Session;
use Redirect;

class DmxController extends Controller
{
    public function index()
    {
        return view('dmx.index', ['fixtures' => DmxFixture::all()]);
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
