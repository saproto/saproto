<?php

namespace App\Models;

use App\Enums\MembershipTypeEnum;
use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;

/**
 * Member Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $proto_username
 * @property string|null $membership_form_id
 * @property string|null $card_printed_on
 * @property bool $is_lifelong
 * @property MembershipTypeEnum $membership_type
 * @property bool $is_honorary
 * @property bool $is_donor
 * @property bool $is_pending
 * @property bool $is_pet
 * @property bool $is_primary_at_another_association
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $until
 * @property User $user
 * @property-read StorageEntry|null $membershipForm
 * @property StorageEntry|null $customOmnomcomSound
 *
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
 *
 * @mixin Eloquent
 */
class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'membership_type' => MembershipTypeEnum::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function membershipForm(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'membership_form_id');
    }

    public function customOmnomcomSound(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'omnomcom_sound_id');
    }

    public static function countActiveMembers(): int
    {
        return User::query()->whereHas('committees')->count();
    }

    public static function countPendingMembers(): int
    {
        return User::query()->whereHas('member', static function ($query) {
            $query->where('is_pending', true);
        })->count();
    }

    public static function countValidMembers(): int
    {
        return User::query()->whereHas('member', static function ($query) {
            $query->where('is_pending', false);
        })->count();
    }

    public function getMembershipOrderline(): ?OrderLine
    {
        $year_start = intval(date('n')) >= 9 ? intval(date('Y')) : intval(date('Y')) - 1;

        return OrderLine::query()
            ->whereIn('product_id', array_values(config('omnomcom.fee')))
            ->where('created_at', '>=', $year_start.'-09-01 00:00:01')
            ->where('user_id', '=', $this->user->id)
            ->first();
    }

    public function getMemberType(): ?string
    {
        $membershipOrderline = $this->getMembershipOrderline();

        if ($membershipOrderline instanceof OrderLine) {
            return match ($this->getMembershipOrderline()->product->id) {
                config('omnomcom.fee')['regular'] => 'primary',
                config('omnomcom.fee')['reduced'] => 'secondary',
                config('omnomcom.fee')['remitted'] => 'non-paying',
                default => 'unknown',
            };
        }

        return null;
    }

    /**
     * Create an email alias friendly username from a full name.
     *
     * @param  $name  string
     */
    public static function createProtoUsername(string $name): string
    {
        $name = explode(' ', $name);
        if (count($name) > 1) {
            $usernameBase = strtolower(Str::transliterate(
                preg_replace('/\PL/u', '', substr($name[0], 0, 1))
                .'.'.
                preg_replace('/\PL/u', '', implode('', array_slice($name, 1)))
            ));
        } else {
            $usernameBase = strtolower(Str::transliterate(
                preg_replace('/\PL/u', '', $name[0])
            ));
        }

        // make sure usernames are max 20 characters long (windows limitation)
        $usernameBase = substr($usernameBase, 0, 17);

        $username = $usernameBase;
        $i = Member::query()->where('proto_username', $username)->withTrashed()->count();
        if ($i > 0) {
            return "{$usernameBase}-{$i}";
        }

        return $username;
    }
}
