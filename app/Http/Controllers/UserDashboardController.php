<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

use Proto\Mail\UserMailChange;
use Redirect;

use Proto\Models\User;

use Carbon\Carbon;

use DateTime;
use Auth;
use Session;
use Validator;
use Mail;

class UserDashboardController extends Controller
{

    /**
     * Display the dashboard for a specific user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();

        $qrcode = null;
        $tfakey = null;
        if (!$user->tfa_totp_key) {
            $google2fa = new Google2FA();
            $tfakey = $google2fa->generateSecretKey(32);
            $qrcode = $google2fa->getQRCodeGoogleUrl('S.A.%20Proto', str_replace(' ', '%20', $user->name), $tfakey);
        }

        return view('users.dashboard.dashboard', ['user' => $user, 'tfa_qrcode' => $qrcode, 'tfa_key' => $tfakey]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $userdata['email'] = $request->input('email');
        $userdata['website'] = $request->input('website');

        if ($user->phone) {
            $userdata['phone'] = str_replace(' ', '', $request->input('phone'));
            $userdata['phone_visible'] = $request->has('phone_visible');
            $userdata['receive_sms'] = $request->has('receive_sms');
            $validator = Validator::make($userdata, [
                'phone' => 'required|regex:(\+[0-9]{8,16})'
            ]);
            if ($validator->fails()) {
                return Redirect::route('user::dashboard')->withErrors($validator);
            }
        }

        if ($user->member) {
            $userdata['show_birthday'] = $request->has('show_birthday');
            $userdata['show_omnomcom_total'] = $request->has('show_omnomcom_total');
            $userdata['show_omnomcom_calories'] = $request->has('show_omnomcom_calories');
            $userdata['show_achievements'] = $request->has('show_achievements');
        }

        if ($request->has('disable_omnomcom')) {
            $userdata['disable_omnomcom'] = true;
        }

        $userdata['keep_omnomcom_history'] = $request->has('keep_omnomcom_history');
        $userdata['theme'] = $request->input('theme');

        if ($userdata['email'] !== $user->email) {

            $validator = Validator::make($userdata, [
                'email' => 'required|email|unique:users',
            ]);
            if ($validator->fails()) {
                return Redirect::route('user::dashboard')->withErrors($validator);
            }

            $email = [
                'old' => $user->email,
                'new' => $userdata['email']
            ];

            $to = [
                (object)[
                    'email' => $email['old'],
                    'name' => $user->name
                ],
                (object)[
                    'email' => $email['new'],
                    'name' => $user->name
                ]
            ];

            $changer = [
                'name' => Auth::user()->name,
                'ip' => $request->ip()
            ];

            Mail::to($to)->queue((new UserMailChange($user, $changer, $email))->onQueue('high'));

        }

        $user->fill($userdata);
        $user->save();

        Session::flash("flash_message", "Changes saved.");
        return Redirect::route('user::dashboard');

    }

    public function editDiet(Request $request)
    {

        $user = Auth::user();

        $user->diet = $request->input('diet');
        $user->save();

        Session::flash("flash_message", "Your diet and allergy information has been updated.");
        return Redirect::route('user::dashboard');

    }

    public function becomeAMemberOf()
    {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = null;
        }

        $steps = [
            [
                'url' => sprintf('%s?wizard=1', route("login::register")),
                'unlocked' => true,
                'done' => Auth::check(),
                'heading' => "Create an account",
                'icon' => "fas fa-user-plus",
                'text' => "In order to become a member of Study Association Proto, you need a Proto account. You can create that here. After creating your account, activate it by using the link mailed to you."
            ],
            [
                'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::edu::add', ['id' => $user->id])) : null,
                'unlocked' => Auth::check(),
                'done' => Auth::check() && Auth::user()->edu_username,
                'heading' => "Link your UTwente account",
                'icon' => "fas fa-university",
                'text' => "If you are a student at the University of Twente, we would appreciate it if you would add your student account to your Proto account. If you don't study at the University of Twente, you can skip this step."
            ],
            [
                'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::memberprofile::complete')) : null,
                'unlocked' => Auth::check(),
                'done' => Auth::check() && Auth::user()->hasCompletedProfile(),
                'heading' => "Provide some personal details",
                'icon' => "fas fa-id-card",
                'text' => "To enter your in our member administration, you need to provide is with some extra information."
            ],
            [
                'url' => Auth::check() ? sprintf('%s?wizard=1', route("user::bank::add", ["id" => $user->id])) : null,
                'unlocked' => Auth::check(),
                'done' => Auth::check() && Auth::user()->bank,
                'heading' => "Provide payment details",
                'icon' => "fas fa-euro-sign",
                'text' => "We need your bank authorisation to withdraw your membership fee, but also your purchases within the Omnomcom and fees of activities you attend."
            ],
            [
                'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::address::add', ['id' => $user->id])) : null,
                'unlocked' => Auth::check(),
                'done' => Auth::check() && Auth::user()->address,
                'heading' => "Provide contact details",
                'icon' => "fas fa-home",
                'text' => "To make you a member of our association, we need your postal address. Please add it to your account here."
            ],
            [
                'url' => sprintf('%s?wizard=1', route('page::show', ['slug' => 'board'])),
                'unlocked' => Auth::check() && Auth::user()->hasCompletedProfile() && Auth::user()->bank && Auth::user()->address,
                'done' => Auth::check() && Auth::user()->member,
                'heading' => "Become a member!",
                'icon' => "fas fa-trophy",
                'text' => "You're almost a full-fledged Proto member! You'll need to find one of the board-members to finalize your registration. They can usually be found in the Protopolis (Zilverling A230)."
            ],
            [
                'url' => sprintf('%s?wizard=1', route('user::dashboard')),
                'unlocked' => Auth::check() && Auth::user()->member,
                'done' => false,
                'heading' => "Add some additional info on your dashboard",
                'icon' => "fas fa-tachometer-alt",
                'text' => "Congratulations, you're now a member of Study Association Proto! As a next step, we would like to guide you to your dashboard, where you can sign up for (educational) mailing lists, some of which provide you regular information about your study, as well as some that provide you with Proto-related information. On your dashboard you can also add a profile picture and indicate any allergies or dietary restrictions you may have so Proto can take those into account when you're visiting an activity."
            ]
        ];

        $todo = [];
        $done = [];

        foreach ($steps as $step) {
            if ($step['done']) array_push($done, $step);
            else array_push($todo, $step);
        }

        return view("users.becomeamember", ['user' => $user, 'todo' => $todo, 'done' => $done]);
    }

    public function getCompleteProfile()
    {
        $user = Auth::user();
        if ($user->hasCompletedProfile()) {
            Session::flash("flash_message", "Your membership profile is already complete.");
            return Redirect::route('becomeamember');
        }

        return view("users.dashboard.completeprofile");
    }

    public function postCompleteProfile(Request $request)
    {
        $user = Auth::user();
        if ($user->hasCompletedProfile()) {
            Session::flash("flash_message", "Your membership profile is already complete.");
            return Redirect::route('becomeamember');
        }

        $userdata = Session::has('flash_userdata') ? Session::get('flash_userdata') : $request->only(['birthdate', 'phone']);

        $validator = Validator::make($userdata, [
            'birthdate' => 'required|date',
            'phone' => 'required|regex:(\+[0-9]{8,16})'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if (Session::has('flash_userdata') && $request->has('verified')) {
            $userdata['birthdate'] = date('Y-m-d', strtotime($userdata['birthdate']));
            $user->fill($userdata);
            $user->save();

            Session::flash("flash_message", "Completed profile.");
            return Redirect::route('becomeamember');
        } else {
            Session::flash('flash_userdata', $userdata);
            return view("users.dashboard.completeprofile_verify",
                ['userdata' => $userdata, 'age' => Carbon::instance(new DateTime($userdata['birthdate']))->age]);
        }
    }

    public function getClearProfile()
    {
        $user = Auth::user();
        if (!$user->hasCompletedProfile()) {
            abort(403, "You have not yet completed your membership profile.");
        }
        if ($user->member) {
            abort(403, "You cannot clear your membership profile while your membership is active.");
        }

        return view("users.dashboard.clearprofile", ['user' => $user]);
    }

    public function postClearProfile()
    {
        $user = Auth::user();
        if (!$user->hasCompletedProfile()) {
            abort(403, "You have not yet completed your membership profile.");
        }
        if ($user->member) {
            abort(403, "You cannot clear your membership profile while your membership is active.");
        }

        $user = Auth::user();
        $user->clearMemberProfile();

        Session::flash("flash_message", "Profile cleared.");
        return Redirect::route('user::dashboard');
    }

    public function generateKey()
    {
        $user = Auth::user();

        $user->generateNewPersonalKey();

        Session::flash("flash_message", "New personal key generated.");
        return Redirect::route('user::dashboard');
    }

}
