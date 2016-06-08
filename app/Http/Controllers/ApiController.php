<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\Event;
use Proto\Models\Activity;

use Auth;

class ApiController extends Controller
{
    public function members(Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $users = User::all();
        $data = array();

        foreach ($users as $user) {
            if (!$user->member) continue;
            if ($request->has('term') && strpos(strtolower($user->name), strtolower($request->term)) === false) continue;

            $member = new \stdClass();
            $member->name = $user->name;
            $member->id = $user->id;
            $data[] = $member;
        }

        return $data;

    }

    public function train(Request $request) {

        return stripslashes(file_get_contents("http://@ews-rpx.ns.nl/mobile-api-avt?station=".$_GET['station']));

    }

}
