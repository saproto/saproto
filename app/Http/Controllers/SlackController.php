<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use SlackApi;

class SlackController extends Controller
{
    /**
     * @param Request $request
     * @return int
     */
    public function getOnlineCount(Request $request)
    {
        // Because this may be Ajax loaded in the middle of a sequence using flash data.
        $request->session()->reflash();

        try {
            $users = SlackApi::execute('users.list', ['presence' => true]);
            $count = 0;
            foreach ($users['members'] as $user) {
                if (in_array('presence', array_keys($user)) && $user['presence'] == 'active') {
                    $count++;
                }
            }

            return $count;
        } catch (SlackApiException $e) {
            return 0;
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function inviteUser(Request $request)
    {
        // Because this may be Ajax loaded in the middle of a sequence using flash data.
        $request->session()->reflash();

        try {
            SlackApi::execute('users.admin.invite', ['email' => Auth::user()->email]);

            return "You've got an invite!";
        } catch (SlackApiException $e) {
            switch ($e->getMessage()) {
                case 'already_invited':
                    return "You've already been invited!";
                    break;
                case 'already_in_team':
                    return "You're already in the team silly!";
                    break;
                default:
                    return 'Something went wrong...';
                    break;
            }
        }
    }

    /**
     * @param $text
     * @param null $channel
     */
    public static function sendNotification($text, $channel = null)
    {
        $channel = ($channel == null ? config('proto.slackchannel') : $channel);
        SlackApi::execute('chat.postMessage', [
            'text' => $text,
            'channel' => $channel,
            'username' => 'Slacqueline the Proto Bot',
            'icon_emoji' => ':woman:',
        ]);
    }
}
