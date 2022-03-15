<?php

namespace Proto\Http\Controllers;

use Auth;
use Carbon;
use Illuminate\Database\Eloquent\Collection;
use Proto\Models\AchievementOwnership;
use Proto\Models\Address;
use Proto\Models\CommitteeMembership;
use Proto\Models\OrderLine;
use Proto\Models\User;

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
    public function getPurchases()
    {
        return Orderline::where('user_id', Auth::id())->with('product')->orderBy('created_at', 'DESC')->limit(100)->get();
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
}
