<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session;

class DiscordController extends Controller
{
    public function discordLinkRedirect()
    {
        $authoriseURL = 'https://discord.com/api/oauth2/authorize?';
        $params = [
            'client_id' => config('proto.discord_client_id'),
            'redirect_uri' => route('api::discord::linked'),
            'response_type' => 'code',
            'scope' => 'identify',
        ];

        return redirect()->away($authoriseURL.http_build_query($params));
    }

    public function discordLinkCallback(Request $request)
    {
        $tokenURL = 'https://discord.com/api/oauth2/token';
        $apiURLBase = 'https://discord.com/api/users/@me';
        $tokenData = [
            'client_id' => config('proto.discord_client_id'),
            'client_secret' => config('proto.discord_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->get('code'),
            'redirect_uri' => route('api::discord::linked'),
            'scope' => 'identify',
        ];

        $client = new GuzzleHttp\Client();
        try {
            $accessTokenData = $client->post($tokenURL, ['form_params' => $tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());
        } catch (ClientException) {
            Session::flash('flash_message', 'Something went wrong when trying to link this Discord account. Try again later.');

            return redirect()->route('user::dashboard');
        }

        $userData = Http::withToken($accessTokenData->access_token)->get($apiURLBase);
        $userData = json_decode($userData);

        if (User::firstWhere('discord_id', $userData->id)) {
            session()->flash('flash_message', 'This Discord account is already linked to a user!');

            return redirect()->route('user::dashboard');
        }

        $user = Auth::user();
        $user->discord_id = $userData->id;
        $user->save();

        session()->flash('flash_message', 'Successfully linked Discord!');

        return redirect()->route('user::dashboard');
    }

    public function discordUnlink()
    {
        $user = Auth::user();
        $user->discord_id = null;
        $user->save();

        session()->flash('flash_message', 'Discord account has been unlinked.');

        return redirect()->route('user::dashboard');
    }
}
