<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Email;
use Proto\Models\EmailList;
use Proto\Models\StorageEntry;
use Proto\Models\Event;
use Proto\Models\User;
use Proto\Models\EmailListSubscription;

use Auth;
use Redirect;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('emailadmin.overview', []);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emailadmin.editmail', ['email' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (strtotime($request->input('time')) === false) {
            $request->session()->flash('flash_message', 'Schedule time improperly formatted.');
            return Redirect::route('email::admin');
        }
        $email = Email::create([
            'description' => $request->input('description'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'time' => strtotime($request->input('time')),
            'sender_name' => $request->input('sender_name'),
            'sender_address' => $request->input('sender_address'),
        ]);
        $this->updateEmailDestination($email, $request->input('destinationType'), $request->input('listSelect'));
        $request->session()->flash('flash_message', 'Your e-mail has been saved.');
        return Redirect::route('email::admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Email::findOrFail($id);
        return view('emails.manualemail', [
            'body' => $email->parseBodyFor(Auth::user()),
            'attachments' => $email->attachments,
            'destination' => $email->destinationForBody(),
            'user_id' => Auth::user()->id
        ]);
    }

    public function newsletterPreview()
    {
        return view('emails.newsletter', [
            'user' => Auth::user(),
            'list' => EmailList::find(config('proto.weeklynewsletter')),
            'events' => Event::getEventsForNewsletter()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        if ($email->sent || $email->ready) {
            $request->session()->flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');
            return Redirect::route('email::admin');
        }
        return view('emailadmin.editmail', ['email' => $email]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        if ($email->sent || $email->ready) {
            $request->session()->flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');
            return Redirect::route('email::admin');
        }
        if (strtotime($request->input('time')) === false) {
            $request->session()->flash('flash_message', 'Schedule time improperly formatted.');
            return Redirect::route('email::admin');
        }
        $email->fill([
            'description' => $request->input('description'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'time' => strtotime($request->input('time')),
            'sender_name' => $request->input('sender_name'),
            'sender_address' => $request->input('sender_address'),
        ]);
        $this->updateEmailDestination($email, $request->input('destinationType'), $request->input('listSelect'));
        $request->session()->flash('flash_message', 'Your e-mail has been saved.');
        return Redirect::route('email::admin');
    }

    public function toggleReady(Request $request, $id)
    {
        $email = Email::findOrFail($id);

        if ($email->sent) {
            $request->session()->flash('flash_message', 'This e-mail has been sent and can thus not be edited.');
            return Redirect::route('email::admin');
        }

        if ($email->ready) {
            $email->ready = false;
            $email->save();
            $request->session()->flash('flash_message', 'The e-mail has been put on hold.');
            return Redirect::route('email::admin');
        } else {
            if ($email->time - date('U') < 15 * 60) {
                $request->session()->flash('flash_message', 'An e-mail can only be queued for delivery if the delivery time is at least 15 minutes in the future.');
                return Redirect::route('email::admin');
            }
            $email->ready = true;
            $email->save();
            $request->session()->flash('flash_message', 'The e-mail has been queued for deliver at the specified time.');
            return Redirect::route('email::admin');
        }
    }

    public function addAttachment(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        if ($email->sent || $email->ready) {
            $request->session()->flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');
            return Redirect::route('email::admin');
        }

        $upload = $request->file('attachment');
        if ($upload) {
            $file = new StorageEntry();
            $file->createFromFile($upload);
            $email->attachments()->attach($file);
            $email->save();
        } else {
            $request->session()->flash('flash_message', 'Do not forget the attachment.');
            return Redirect::route('email::edit', ['id' => $email->id]);
        }

        $request->session()->flash('flash_message', 'Attachment uploaded.');
        return Redirect::route('email::edit', ['id' => $email->id]);

    }

    public function deleteAttachment(Request $request, $id, $file_id)
    {
        $email = Email::findOrFail($id);
        if ($email->sent || $email->ready) {
            $request->session()->flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');
            return Redirect::route('email::admin');
        }

        $file = StorageEntry::findOrFail($file_id);

        $email->attachments()->detach($file);
        $email->save();

        $request->session()->flash('flash_message', 'Attachment deleted.');
        return Redirect::route('email::edit', ['id' => $email->id]);
    }

    public function unsubscribeLink(Request $request, $hash)
    {
        $data = EmailList::parseUnsubscribeHash($hash);
        $user = User::findOrFail($data->user);
        $list = EmailList::findOrFail($data->list);
        $sub = EmailListSubscription::where('user_id', $user->id)->where('list_id', $list->id)->first();
        if ($sub != null) {
            $request->session()->flash('flash_message', $user->name . ' has been unsubscribed from ' . $list->name);
            $sub->delete();
        } else {
            $request->session()->flash('flash_message', $user->name . ' was already unsubscribed from ' . $list->name);
        }
        return Redirect::route('homepage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        if ($email->sent) {
            $request->session()->flash('flash_message', 'This e-mail has been sent and can thus not be deleted.');
            return Redirect::route('email::admin');
        }
        $email->delete();
        $request->session()->flash('flash_message', 'The e-mail has been deleted.');
        return Redirect::route('email::admin');
    }

    private function updateEmailDestination(Email $email, $type, $lists = null)
    {
        switch ($type) {
            case 'users':
                $email->to_user = true;
                $email->to_member = false;
                $email->to_list = false;
                $email->lists()->sync([]);
                break;
            case 'members':
                $email->to_user = false;
                $email->to_member = true;
                $email->to_list = false;
                $email->lists()->sync([]);
                break;

            case 'lists':
                $email->to_user = false;
                $email->to_member = false;
                $email->to_list = true;
                $email->lists()->sync($lists);
                break;
            default:
                abort(500, 'Invalid e-mail destination');
                break;
        }
        $email->save();
    }
}
