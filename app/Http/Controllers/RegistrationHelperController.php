<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\User;

class RegistrationHelperController extends Controller
{
    /**
     * Display a list of pending members.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('query');

        $users = User::whereHas('member', function ($q) {
            $q->where('is_pending', true);
        });

        if ($search) {
            $users = $users->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('calling_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('utwente_username', 'LIKE', "%$search%")
                    ->orWhereHas('member', function ($q) use ($search) {
                        $q->where('proto_username', 'LIKE', "%$search%");
                    });
            });
        }

        $users = $users->paginate(20);

        return view('users.admin.registrationhelper.overview', ['users' => $users, 'query' => $search]);
    }

    /**
     * Show the user details for registration helper.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function details($id)
    {
        $user = User::whereHas('member', function ($q) {
            $q->where('is_pending', true);
        })->findOrFail($id);
        $memberships = $user->getMemberships();

        return view('users.admin.registrationhelper.details', ['user' => $user, 'memberships' => $memberships]);
    }
}
