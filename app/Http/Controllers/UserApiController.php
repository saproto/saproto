<?php

namespace App\Http\Controllers;

use App\Models\AchievementOwnership;
use App\Models\Address;
use App\Models\CommitteeMembership;
use App\Models\OrderLine;
use App\Models\User;
use GuzzleHttp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Session;

class UserApiController extends Controller
{
    /** @return User|null */
    public function getUser()
    {
        return Auth::user();
    }

    /** @return string|false */
    public function getUserProfilePicture()
    {
        return json_encode((object) [
            's' => Auth::user()->generatePhotoPath(100, 100),
            'm' => Auth::user()->generatePhotoPath(512, 512),
            'l' => Auth::user()->generatePhotoPath(1024, 1024),
        ]);
    }

    /** @return Address */
    public function getAddress()
    {
        return Auth::user()->address;
    }

    /**
     * @return Collection|CommitteeMembership[]
     */
    public function getCommittees()
    {
        return CommitteeMembership::where('user_id', Auth::id())->with('committee')->get()->where('is_society', false);
    }

    /**
     * @return Collection|CommitteeMembership[]
     */
    public function getSocieties()
    {
        return CommitteeMembership::where('user_id', Auth::id())->with('committee')->get()->where('is_society', true);
    }

    /**
     * @return Collection|AchievementOwnership[]
     */
    public function getAchievements()
    {
        return AchievementOwnership::where('user_id', Auth::id())->with('achievement')->get();
    }

    /**
     * @return Collection|OrderLine[]
     */
    public function getPurchases(Request $request)
    {
        $validated = $request->validate([
            'from' => 'date',
            'to' => 'date',
        ]);

        $orderlines = Orderline::where('user_id', Auth::id())->with('product');

        if ($request->has('from')) {
            $orderlines = $orderlines->where('created_at', '>', $validated['from']);
        }
        if ($request->has('to')) {
            $orderlines = $orderlines->where('created_at', '<', $validated['to']);
        }

        $orderlines = $orderlines->orderBy('created_at', 'DESC');
        if (! $request->has('from') && ! $request->has('to')) {
            $orderlines = $orderlines->limit(100);
        }

        return $orderlines->get();
    }

    /** @return int */
    public function getNextWithdrawal()
    {
        return $orderlines = Orderline::where('user_id', Auth::id())->whereNull('payed_with_bank_card')->whereNull('payed_with_cash')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->sum('total_price');
    }

    /** @return int */
    public function getPurchasesMonth()
    {
        $orderlines = OrderLine::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m');
        });

        $total = 0;
        if ($orderlines->has(date('Y-m'))) {
            $selected_orders = $orderlines[Carbon::parse(date('Y-m'))->format('Y-m')];
            foreach ($selected_orders as $orderline) {
                $total += $orderline->total_price;
            }
        }

        return $total;
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
            'redirect_uri' => config('app.url').'api/discord/linked',
            'scope' => 'identify',
        ];

        $client = new GuzzleHttp\Client();
        try {
            $accessTokenData = $client->post($tokenURL, ['form_params' => $tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $error) {
            Session::flash('flash_message', 'Failed to link Discord account :('.$error);

            return Redirect::back();
        }

        $userData = Http::withToken($accessTokenData->access_token)->get($apiURLBase);
        $userData = json_decode($userData);

        if (User::firstWhere('discord_id', $userData->id)) {
            Session::flash('flash_message', 'This Discord account is already linked to a user!');

            return Redirect::back();
        }

        $user = Auth::user();
        $user->discord_id = $userData->id;
        $user->save();

        Session::flash('flash_message', 'Successfully linked Discord!');

        return Redirect::route('user::dashboard');
    }

    public function discordUnlink()
    {
        $user = Auth::user();
        $user->discord_id = null;
        $user->save();

        Session::flash('flash_message', 'Discord account has been unlinked.');

        return Redirect::route('user::dashboard');
    }
}
