<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Proto\Models\AchievementOwnership;
use Proto\Models\CommitteeMembership;
use Proto\Models\OrderLine;

class UserApiController extends Controller
{

    public function getUser()
    {
        return Auth::user();
    }

    public function getUserProfilePicture()
    {
        return json_encode((object)[
            's' => Auth::user()->generatePhotoPath(100, 100),
            'm' => Auth::user()->generatePhotoPath(512, 512),
            'l' => Auth::user()->generatePhotoPath(1024, 1024),
        ]);
    }

    public function getAddress()
    {
        return Auth::user()->address;
    }

    public function getCommittees()
    {
        return CommitteeMembership::where('user_id', Auth::id())->with('committee')->get();
    }

    public function getAchievements()
    {
        return AchievementOwnership::where('user_id', Auth::id())->with('achievement')->get();
    }

    public function getPurchases()
    {
        return Orderline::where('user_id', Auth::id())->with('product')->limit(100)->get();
    }

}
