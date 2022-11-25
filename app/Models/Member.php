<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property string|null $card_printed_on
 * @property bool $is_lifelong
 * @property bool $is_honorary
 * @property bool $is_donor
 * @property bool $is_pending
 * @property bool $is_pet
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @property-read StorageEntry|null $membershipForm
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static QueryBuilder|Member onlyTrashed()
 * @method static QueryBuilder|Member withTrashed()
 * @method static QueryBuilder|Member withoutTrashed()
 * @method static Builder|Member whereCardPrintedOn($value)
 * @method static Builder|Member whereCreatedAt($value)
 * @method static Builder|Member whereDeletedAt($value)
 * @method static Builder|Member whereId($value)
 * @method static Builder|Member whereIsDonor($value)
 * @method static Builder|Member whereIsHonorary($value)
 * @method static Builder|Member whereIsLifelong($value)
 * @method static Builder|Member whereMembershipFormId($value)
 * @method static Builder|Member wherePending($value)
 * @method static Builder|Member whereProtoUsername($value)
 * @method static Builder|Member whereUpdatedAt($value)
 * @method static Builder|Member whereUserId($value)
 * @method static Builder|Member whereIsPending($value)
 * @method static Builder|Member whereIsPet($value)
 * @method static Builder|Member newModelQuery()
 * @method static Builder|Member newQuery()
 * @method static Builder|Member query()
 * @mixin Eloquent
 */
class Member extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    protected $dates = ['deleted_at'];

    /** @return BelongsTo */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo */
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

    public static function countPendingMembers()
    {
        return User::whereHas('member', function ($query) { $query->where('is_pending', true); })->count();
    }

    public static function countValidMembers()
    {
        return User::whereHas('member', function ($query) { $query->where('is_pending', false); })->count();
    }

    /** @return OrderLine|null */
    public function getMembershipOrderline()
    {
        if (intval(date('n')) >= 9) {
            $year_start = intval(date('Y'));
        } else {
            $year_start = intval(date('Y')) - 1;
        }

        return OrderLine::query()
            ->whereIn('product_id', array_values(config('omnomcom.fee')))
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

    /**
     * Create an email alias friendly username from a full name.
     *
     * @param $name string
     * @return string
     */
    public static function createProtoUsername($name)
    {
        $name = explode(' ', $name);
        if (count($name) > 1) {
            $usernameBase = self::transliterateString(strtolower(
                preg_replace('/\PL/u', '', substr($name[0], 0, 1))
                .'.'.
                preg_replace('/\PL/u', '', implode('', array_slice($name, 1)))
            ));
        } else {
            $usernameBase = self::transliterateString(strtolower(
                preg_replace('/\PL/u', '', $name[0])
            ));
        }

        // make sure usernames are max 20 characters long (windows limitation)
        $usernameBase = substr($usernameBase, 0, 17);

        $username = $usernameBase;
        $i = Member::where('proto_username', $username)->withTrashed()->count();
        if ($i > 0) {
            $username = "$usernameBase-$i";
        }

        return $username;
    }

    /**
     * Replace all strange characters in a string with normal ones.
     * Shamelessly borrowed from http://stackoverflow.com/a/6837302.
     *
     * @param string $txt
     * @return string|string[]
     */
    protected static function transliterateString($txt)
    {
        $transliterationTable = ['á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja'];

        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
    }
}
