<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use SlackApi;
use Auth;

use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

class SlackController extends Controller
{
    public function getOnlineCount()
    {
        try {
            $users = SlackApi::execute('users.list', ['presence' => true]);
            $count = 0;
            foreach ($users['members'] as $user) {
                if (in_array('presence', array_keys($user)) && $user['presence'] == 'active') $count++;
            }
            return $count;
        } catch (SlackApiException $e) {
            return 0;
        }
    }

    public function inviteUser()
    {
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
                    return "Something went wrong...";
                    break;
            }
        }
    }
}
