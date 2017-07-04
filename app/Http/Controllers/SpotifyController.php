<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\HashMapItem;

use Redirect;


class SpotifyController extends Controller
{
    /**
     * A dummy OAuth flow to generate a token for the Spotify API.
     */
    public function oauthTool(Request $request)
    {
        $session = new \SpotifyWebAPI\Session(
            getenv('SPOTIFY_CLIENT'),
            getenv('SPOTIFY_SECRET'),
            route("spotify::oauth")
        );

        $api = new \SpotifyWebAPI\SpotifyWebAPI();

        if (!$request->has('code')) {

            $options = [
                'scope' => [
                    'playlist-modify-public',
                ]
            ];

            return Redirect::to($session->getAuthorizeUrl($options));

        } else {

            $session->requestAccessToken($request->get('code'));
            $api->setAccessToken($session->getAccessToken());

            $spotify_user = $api->me()->id;
            $right_user = getenv('SPOTIFY_USER');
            if ($spotify_user != $right_user) {
                abort(404, "You authenticated as the wrong user. (Authenticated as $spotify_user but should authenticate as $right_user.)");
            }

            SpotifyController::setSession($session);
            SpotifyController::setApi($api);

            $request->session()->flash('flash_message', 'Successfully saved Spotify credentials.');
            return Redirect::route('homepage');

        }
    }

    public static function setSession($session)
    {
        $dbSession = HashMapItem::where('key', 'spotify')->where('subkey', 'session')->first();
        if ($dbSession == null) {
            $dbSession = HashMapItem::create([
                'key' => 'spotify',
                'subkey' => 'session'
            ]);
        }
        $dbSession->value = serialize($session);
        $dbSession->save();
    }

    public static function setApi($api)
    {
        $dbApi = HashMapItem::where('key', 'spotify')->where('subkey', 'api')->first();
        if ($dbApi == null) {
            $dbApi = HashMapItem::create([
                'key' => 'spotify',
                'subkey' => 'api'
            ]);
        }
        $dbApi->value = serialize($api);
        $dbApi->save();
    }

    public static function getSession()
    {
        return unserialize(
            HashMapItem::where('key', 'spotify')->where('subkey', 'session')
                ->first()->value
        );
    }

    public static function getApi()
    {
        return unserialize(
            HashMapItem::where('key', 'spotify')->where('subkey', 'api')
                ->first()->value
        );
    }
}
