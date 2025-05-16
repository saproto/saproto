<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class EmailListController extends Controller
{
    public function create(): View
    {
        return view('emailadmin.editlist', ['list' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        EmailList::query()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_member_only' => $request->has('is_member_only'),
        ]);

        Session::flash('flash_message', 'Your list has been created!');

        return Redirect::route('email::index');
    }

    public function edit(int $id): View
    {
        return view('emailadmin.editlist', ['list' => EmailList::query()->findOrFail($id)]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $list = EmailList::query()->findOrFail($id);
        $list->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_member_only' => $request->has('is_member_only'),
        ]);
        $list->save();

        Session::flash('flash_message', 'The list has been updated!');

        return Redirect::route('email::index');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $list = EmailList::query()->findOrFail($id);
        $list->delete();

        Session::flash('flash_message', 'The list has been deleted!');

        return Redirect::route('email::index');
    }

    public static function autoSubscribeToLists(string $type, User $user): void
    {
        $lists = Config::array('proto.'.$type);
        foreach ($lists as $list) {
            $list = EmailList::query()->find($list);
            if ($list) {
                $list->subscribe($user);
            }
        }
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function toggleSubscription(Request $request, int $id)
    {
        $user = Auth::user();
        /** @var EmailList $list */
        $list = EmailList::query()->findOrFail($id);

        if ($list->isSubscribed($user)) {
            if ($list->unsubscribe($user)) {
                Session::flash('flash_message', 'You have been unsubscribed to the list '.$list->name.'.');

                return Redirect::route('user::dashboard::show');
            }
        } else {
            if ($list->is_member_only && ! $user->is_member) {
                Session::flash('flash_message', 'This list is only for members.');

                return Redirect::route('user::dashboard::show');
            }

            if ($list->subscribe($user)) {
                Session::flash('flash_message', 'You have been subscribed to the list '.$list->name.'.');

                return Redirect::route('user::dashboard::show');
            }
        }

        Session::flash('flash_message', 'Something went wrong toggling your subscription for '.$list->name.'.');

        return Redirect::route('user::dashboard::show');
    }
}
