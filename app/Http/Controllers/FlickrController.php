<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;

use Proto\Models\HashMapItem;

use Proto\CustomClasses\FlickrOauthClient;

class FlickrController extends Controller
{
    /**
     * A dummy OAuth flow to generate a token for the Flickr API.
     */
    public function oauthTool(Request $request)
    {
        $flickr = new FlickrOauthClient([
            'identifier' => config('flickr.client-id'),
            'secret' => config('flickr.client-secret'),
            'callback_uri' => route('flickr::oauth'),
            'scope' => 'read'
        ]);

        if (!$request->has('oauth_token') || !$request->has('oauth_verifier') || !$request->session()->has('flickr_token')) {

            $token = $flickr->getTemporaryCredentials();

            $request->session()->put('flickr_token', $token);

            return Redirect::to($flickr->getAuthorizationUrl($token));

        } else {

            $token = $request->session()->get('flickr_token');
            $token = $flickr->getTokenCredentials($token, $_GET['oauth_token'], $_GET['oauth_verifier']);

            $request->session()->forget('flickr_token');

            FlickrController::setToken($token);

            $request->session()->flash('flash_message', 'Successfully saved Flickr credentials.');
            return Redirect::route('homepage');

        }
    }

    public static function setToken($api)
    {
        $dbApi = HashMapItem::where('key', 'flickr')->where('subkey', 'token')->first();
        if ($dbApi == null) {
            $dbApi = HashMapItem::create([
                'key' => 'flickr',
                'subkey' => 'token'
            ]);
        }
        $dbApi->value = serialize($api);
        $dbApi->save();
    }

    public static function getToken()
    {
        return unserialize(
            HashMapItem::where('key', 'flickr')->where('subkey', 'token')
                ->first()->value
        );
    }
}
