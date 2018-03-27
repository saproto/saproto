<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\Event;
use Proto\Models\Newsletter;
use Proto\Models\EmailList;

use Redirect;
use Auth;

class NewsletterController extends Controller
{

    public function getInNewsletter()
    {

        $events = Event::where('start', '>', date('U'))->where('secret', false)->orderBy('start', 'asc')->get();

        return view('event.innewsletter', ['events' => $events]);

    }

    public function toggleInNewsletter($id)
    {

        $event = Event::findOrFail($id);

        $event->include_in_newsletter = !$event->include_in_newsletter;
        $event->save();

        return Redirect::back();

    }

    public function newsletterPreview()
    {
        return view('emails.newsletter', [
            'user' => Auth::user(),
            'list' => EmailList::find(config('proto.weeklynewsletter')),
            'events' => Event::getEventsForNewsletter(),
            'text' => Newsletter::getText()->value
        ]);
    }

    public function sendNewsletter(Request $request)
    {
        if (!Auth::user()->can('board')) {
            abort(403, 'Only the board can do this.');
        }

        Newsletter::send();

        $request->session()->flash('flash_message', 'The weekly newsletter has been sent.');
        return Redirect::back();
    }

    public function saveNewsletterText(Request $request)
    {
        Newsletter::updateText($request->text);

        $request->session()->flash('flash_message', 'The newsletter text has been set.');
        return Redirect::back();
    }

}
