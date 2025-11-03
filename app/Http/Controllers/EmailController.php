<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailList;
use App\Models\EmailListSubscription;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;

class EmailController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|Factory
    {
        return view('emailadmin.overview', [
            'lists' => EmailList::query()->withCount('users')->get(),
            'emails' => Email::query()->with('lists')->with('withdrawals')->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function filter(Request $request): View
    {
        $filteredEmails = Email::query()->with('lists')->orderBy('id', 'desc');
        $description = $request->has('search_description');
        $subject = $request->has('search_subject');
        $body = $request->has('search_body');
        $searchTerm = $request->input('searchterm');

        if ($description) {
            $filteredEmails = $filteredEmails->orWhereLike('description', '%'.$searchTerm.'%');
        }

        if ($subject) {
            $filteredEmails = $filteredEmails->orWhereLike('subject', '%'.$searchTerm.'%');
        }

        if ($body) {
            $filteredEmails = $filteredEmails->orWhereLike('body', '%'.$searchTerm.'%');
        }

        return view('emailadmin.overview', [
            'lists' => EmailList::query()->withCount('users')->get(),
            'emails' => $filteredEmails->paginate(10),
            'searchTerm' => $searchTerm,
            'description' => $description,
            'subject' => $subject,
            'body' => $body,
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View|Factory
    {
        return view('emailadmin.editmail', ['email' => null]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'time' => ['required', 'date'],
        ]);

        $senderAddress = $request->input('sender_address');
        if (! filter_var($senderAddress.'@test.com', FILTER_VALIDATE_EMAIL)) {
            Session::flash('flash_message', 'Sender address is not a valid e-mail address.');

            return back();
        }

        $email = Email::query()->create([
            'description' => $request->input('description'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'time' => $request->date('time')->timestamp,
            'sender_name' => $request->input('sender_name'),
            'sender_address' => $senderAddress,
        ]);
        $this->updateEmailDestination($email, $request->input('destinationType'), $request->input('listSelect'), $request->input('eventSelect'), $request->input('withdrawalSelect'), $request->has('toBackup'));
        Session::flash('flash_message', 'Your e-mail has been saved.');

        return to_route('email::index');
    }

    /**
     * @return View
     *
     * @throws Exception
     */
    public function show(int $id): \Illuminate\Contracts\View\View|Factory
    {
        $email = Email::query()->findOrFail($id);

        return view('emails.manualemail', [
            'body' => $email->parseBodyFor(Auth::user()),
            'attachments' => $email->getMedia(),
            'destination' => $email->destinationForBody(),
            'user_id' => Auth::user()->id,
            'events' => $email->events()->get(),
            'email_id' => $email->id,
        ]);
    }

    /**
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        /** @var Email $email */
        $email = Email::query()->findOrFail($id);
        if ($email->sent || $email->ready) {
            Session::flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');

            return to_route('email::index');
        }

        return view('emailadmin.editmail', ['email' => $email]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'time' => ['required', 'date'],
        ]);

        /** @var Email $email */
        $email = Email::query()->findOrFail($id);

        if ($email->sent || $email->ready) {
            Session::flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');

            return to_route('email::index');
        }

        $senderAddress = $request->input('sender_address');
        if (! filter_var($senderAddress.'@test.com', FILTER_VALIDATE_EMAIL)) { // test.com just as a test
            Session::flash('flash_message', 'Sender address is not a valid e-mail address.');

            return back();
        }

        $email->fill([
            'description' => $request->input('description'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'time' => $request->date('time')->timestamp,
            'sender_name' => $request->input('sender_name'),
            'sender_address' => $senderAddress,
        ]);

        $this->updateEmailDestination($email, $request->input('destinationType'), $request->input('listSelect'), $request->input('eventSelect'), $request->input('withdrawalSelect'), $request->has('toBackup'));

        Session::flash('flash_message', 'Your e-mail has been saved.');

        return to_route('email::index');
    }

    /**
     * @return RedirectResponse
     */
    public function toggleReady(int $id)
    {
        /** @var Email $email */
        $email = Email::query()->findOrFail($id);

        if ($email->sent) {
            Session::flash('flash_message', 'This e-mail has been sent and can thus not be edited.');

            return to_route('email::index');
        }

        if ($email->ready) {
            $email->ready = false;
            $email->save();
            Session::flash('flash_message', 'The e-mail has been put on hold.');
        } else {
            if ($email->time - Date::now()->timestamp < 5 * 60) {
                Session::flash('flash_message', 'An e-mail can only be queued for delivery if the delivery time is at least 5 minutes in the future.');

                return to_route('email::index');
            }

            $email->ready = true;
            $email->save();
            Session::flash('flash_message', 'The e-mail has been queued for delivery at the specified time.');
        }

        return to_route('email::index');
    }

    /**
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function addAttachment(Request $request, int $id)
    {
        /** @var Email $email */
        $email = Email::query()->findOrFail($id);
        if ($email->sent || $email->ready) {
            Session::flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');

            return to_route('email::index');
        }

        if ($request->has('attachment')) {
            try {
                $email->addMediaFromRequest('attachment')
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        } else {
            Session::flash('flash_message', 'Do not forget the attachment.');

            return to_route('email::edit', ['id' => $email->id]);
        }

        Session::flash('flash_message', 'Attachment uploaded.');

        return to_route('email::edit', ['id' => $email->id]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws MediaCannotBeDeleted
     */
    public function deleteAttachment(int $id, int $file_id)
    {
        /** @var Email $email */
        $email = Email::query()->findOrFail($id);
        if ($email->sent || $email->ready) {
            Session::flash('flash_message', 'You can currently not edit this e-mail. Please make sure it is in draft mode.');

            return to_route('email::index');
        }

        $email->deleteMedia($file_id);

        Session::flash('flash_message', 'Attachment deleted.');

        return to_route('email::edit', ['id' => $email->id]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function unsubscribeLink(string $hash)
    {
        $data = EmailList::parseUnsubscribeHash($hash);

        /** @var User $user */
        $user = User::query()->findOrFail($data->user);
        $list = EmailList::query()->findOrFail($data->list);

        $sub = EmailListSubscription::query()->where('user_id', $user->id)->where('list_id', $list->id)->first();
        if ($sub != null) {
            Session::flash('flash_message', $user->name.' has been unsubscribed from '.$list->name);
            $sub->delete();
        } else {
            Session::flash('flash_message', $user->name.' was already unsubscribed from '.$list->name);
        }

        return to_route('homepage');
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(int $id)
    {
        /** @var Email $email */
        $email = Email::query()->findOrFail($id);
        if ($email->sent) {
            Session::flash('flash_message', 'This e-mail has been sent and can thus not be deleted.');

            return to_route('email::index');
        }

        $email->delete();
        Session::flash('flash_message', 'The e-mail has been deleted.');

        return to_route('email::index');
    }

    /**
     * @param array<int> $lists
     * @param  array<int>  $events
     * @param  array<int>  $withdrawals
     */
    private function updateEmailDestination(Email $email, string $type, ?array $lists = [], ?array $events = [], ?array $withdrawals = [], bool $toBackup = false): void
    {
        $email->to_user = false;
        switch ($type) {

            case 'members':
                $email->to_pending = false;
                $email->to_member = true;
                $email->to_active = false;

                $email->to_list = false;
                $email->to_event = false;
                $email->to_backup = false;
                $email->to_withdrawal = false;

                $email->lists()->sync([]);
                $email->events()->sync([]);
                $email->withdrawals()->sync([]);
                break;

            case 'pending':
                $email->to_pending = true;
                $email->to_member = false;
                $email->to_active = false;

                $email->to_list = false;
                $email->to_event = false;
                $email->to_backup = false;
                $email->to_withdrawal = false;

                $email->lists()->sync([]);
                $email->events()->sync([]);
                $email->withdrawals()->sync([]);
                break;

            case 'active':
                $email->to_pending = false;
                $email->to_member = false;
                $email->to_active = true;

                $email->to_list = false;
                $email->to_event = false;
                $email->to_backup = false;
                $email->to_withdrawal = false;

                $email->lists()->sync([]);
                $email->events()->sync([]);
                $email->withdrawals()->sync([]);
                break;

            case 'event':
                $email->to_pending = false;
                $email->to_member = false;
                $email->to_active = false;

                $email->to_list = false;
                $email->to_event = true;
                $email->to_backup = $toBackup;
                $email->to_withdrawal = false;
                $email->lists()->sync([]);
                $email->withdrawals()->sync([]);
                if ($events !== null && $events !== []) {
                    $email->events()->sync($events);
                }

                break;

            case 'lists':
                $email->to_pending = false;
                $email->to_member = false;
                $email->to_active = false;

                $email->to_list = true;
                $email->to_event = false;
                $email->to_backup = false;
                $email->to_withdrawal = false;

                $email->lists()->sync($lists);
                $email->events()->sync([]);
                $email->withdrawals()->sync([]);
                break;

            case 'withdrawals':
                $email->to_pending = false;
                $email->to_member = false;
                $email->to_active = false;

                $email->to_list = false;
                $email->to_event = false;
                $email->to_backup = false;
                $email->to_withdrawal = true;

                $email->lists()->sync([]);
                $email->events()->sync([]);
                if ($withdrawals !== null && $withdrawals !== []) {
                    $email->withdrawals()->sync($withdrawals);
                }
                break;

            default:
                $email->to_pending = false;
                $email->to_member = false;
                $email->to_active = false;

                $email->to_list = false;
                $email->to_event = false;
                $email->to_backup = false;

                $email->lists()->sync([]);
                $email->events()->sync([]);
                $email->withdrawals()->sync([]);
                break;
        }

        $email->save();
    }
}
