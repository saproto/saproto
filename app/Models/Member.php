<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Member Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $proto_username
 * @property string|null $membership_form_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_lifelong
 * @property int $is_honorary
 * @property int $is_donator
 * @property string $pending
 * @property Carbon|null $deleted_at
 * @property string|null $card_printed_on
 * @property-read StorageEntry|null $membershipForm
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static QueryBuilder|Member onlyTrashed()
 * @method static QueryBuilder|Member withTrashed()
 * @method static QueryBuilder|Member withoutTrashed()
 * @method static bool|null restore()
 * @method static Builder|Member whereCardPrintedOn($value)
 * @method static Builder|Member whereCreatedAt($value)
 * @method static Builder|Member whereDeletedAt($value)
 * @method static Builder|Member whereId($value)
 * @method static Builder|Member whereIsDonator($value)
 * @method static Builder|Member whereIsHonorary($value)
 * @method static Builder|Member whereIsLifelong($value)
 * @method static Builder|Member whereMembershipFormId($value)
 * @method static Builder|Member wherePending($value)
 * @method static Builder|Member whereProtoUsername($value)
 * @method static Builder|Member whereUpdatedAt($value)
 * @method static Builder|Member whereUserId($value)
 * @mixin Eloquent
 */
class Member extends Model
{
    use SoftDeletes;

    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    protected $dates = ['deleted_at'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo|StorageEntry */
    public function membershipForm()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'membership_form_id');
    }

    /** @return int */
    public static function countActiveMembers()
    {
        $user_ids = [];
        foreach (Committee::all() as $committee) {
            $user_ids = array_merge($user_ids, $committee->users->pluck('id')->toArray());
        }

        return User::whereIn('id', $user_ids)->orderBy('name', 'asc')->count();
    }

    /** @return Orderline */
    public function getMembershipOrderline()
    {
        if (intval(date('n')) >= 9) {
            $year_start = intval(date('Y'));
        } else {
            $year_start = intval(date('Y')) - 1;
        }

        return OrderLine::whereIn('product_id', array_values(config('omnomcom.fee')))
            ->where('created_at', '>=', $year_start.'-09-01 00:00:01')
            ->where('user_id', '=', $this->user->id)
            ->first();
    }

    /** @return string|null */
    public function getMemberType()
    {
        $membershipOrderline = $this->getMembershipOrderline();

        if ($membershipOrderline) {
            switch ($this->getMembershipOrderline()->product->id) {
                case config('omnomcom.fee')['regular']:
                    return 'primary';
                case config('omnomcom.fee')['reduced']:
                    return 'secondary';
                case config('omnomcom.fee')['remitted']:
                    return 'non-paying';
                default:
                    return 'unknown';
            }
        }

        return null;
    }
}
