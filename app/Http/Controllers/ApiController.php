<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\Event;
use Proto\Models\Activity;
use Proto\Models\Token;
use Proto\Models\PlayedVideo;

use Auth;
use Session;

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
    
    public function protubeAdmin($token) {
        $token = Token::where('token', $token)->first();

        if(!$token) return("{\"is_admin\":false}");

        $user = $token->user()->first();

        if(!$user) return("{\"is_admin\":false}");

        $adminInfo = new \stdClass();
        
        if($user->can('board') || $user->isTempadmin()) {
            $adminInfo->is_admin = true;
        }else{
            $adminInfo->is_admin = false;
        }

        return(json_encode($adminInfo));
    }

    public function protubePlayed(Request $request) {
        if($request->secret != env('HERBERT_SECRET')) abort(403);

        $playedVideo = new PlayedVideo();

        $token = Token::where('token', $request->token)->first();

        if($token) {
            $user = $token->user()->first();
            $playedVideo->user()->associate($user);
        }

        $playedVideo->video_id = $request->video_id;
        $playedVideo->video_title = $request->video_title;

        $playedVideo->save();
    }

    public function getToken(Request $request) {
        $response = new \stdClass();

        if(Auth::check()) {
            $response->token = Session::get('token');
        }else{
            $response->token = 0;
        }

        if($request->has('callback')) {
            return $request->callback . "(" . json_encode($response) . ")";
        }else{
            return json_encode($response);
        }
    }

}
