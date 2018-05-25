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
use Input;

class ApiController extends Controller
{

    public function train(Request $request)
    {

        return stripslashes(file_get_contents("http://@ews-rpx.ns.nl/mobile-api-avt?station=" . $_GET['station']));

    }

    public function protubeAdmin($token)
    {
        $token = Token::where('token', $token)->first();

        $adminInfo = new \stdClass();

        if (!$token) {
            $adminInfo->is_admin = false;
        } else {
            $user = $token->user;
            if (!$user) {
                $adminInfo->is_admin = false;
            } else {
                $adminInfo->user_id = $user->id;
                $adminInfo->user_name = $user->name;
                $adminInfo->calling_name = $user->calling_name;
                $adminInfo->is_admin = $user->can('protube') || $user->isTempadmin();
            }
        }

        return (json_encode($adminInfo));

    }

    public function protubePlayed(Request $request)
    {
        if ($request->secret != config('herbert.secret')) abort(403);

        $playedVideo = new PlayedVideo();

        $token = Token::where('token', $request->token)->first();

        if ($token) {
            $user = $token->user()->first();
            if ($user->keep_protube_history) {
                $playedVideo->user()->associate($user);
            }
        }

        $playedVideo->video_id = $request->video_id;
        $playedVideo->video_title = urldecode($request->video_title);

        $playedVideo->save();

        PlayedVideo::where('video_id', $playedVideo->video_id)->update(['video_title' => $playedVideo->video_title]);
    }

    public function getToken(Request $request)
    {
        $response = new \stdClass();

        if (Auth::check()) {
            $response->name = Auth::user()->name;
            $response->photo = Auth::user()->generatePhotoPath(250, 250);
            $response->token = Auth::user()->getToken()->token;
        } else {
            $response->token = 0;
        }

        if ($request->has('callback')) {
            return response()->json($response)->setCallback(Input::get('callback'));
        } else {
            return response()->json($response);
        }
    }

    public function ldapProxy($personal_key)
    {
        $user = User::where('personal_key', $personal_key)->first();
        if (!$user || !$user->member || !$user->utwente_username) {
            abort(403, 'You do not have access to this data. You need to be a member and have a valid UT account linked.');
        }
        $query = (isset($_GET['filter']) ? $_GET['filter'] : '|(false)');
        $url = config('app-proto.utwente-ldap-hook') . "?filter=" . $query;
        return file_get_contents($url);
    }

    public function fishcamStream()
    {
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: multipart/x-mixed-replace; boundary=video-boundary--");
        header('Cache-Control: no-cache');
        $handle = fopen(env("FISHCAM_URL"), "r");
        while ($data = fread($handle, 8192)) {
            echo $data;
            ob_flush();
            flush();
            set_time_limit(0);
        }
    }

}
