<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public static function countActiveMembers()
    {
        $userids = [];
        foreach (Committee::all() as $committee) {
            $userids = array_merge($userids, $committee->users->pluck('id')->toArray());
        }
        return User::whereIn('id', $userids)->orderBy('name', 'asc')->count();
    }

    public function getMembershipOrderline()
    {
        if (intval(date('n')) >= 9) {
            $yearstart = intval(date('Y'));
        } else {
            $yearstart = intval(date('Y')) - 1;
        }

        $orderline = OrderLine::whereIn('product_id', array_values(config('omnomcom.fee')))
            ->where('created_at', '>=', $yearstart . '-09-01 00:00:01')->where('user_id', '=', $this->id)->first();

        return $orderline;
    }

    public function getMemberType()
    {
        $membershipOrderline = $this->getMembershipOrderline();

        if ($membershipOrderline) {
            switch ($this->getMembershipOrderline()->product->id) {
                case config('omnomcom.fee')['regular']:
                    return 'regular';
                    break;
                case config('omnomcom.fee')['reduced']:
                    return 'secondary';
                default:
                    return 'unknown';
            }
        }

        return null;
    }
}
