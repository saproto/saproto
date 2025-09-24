<?php

namespace App\Models;

use App\Enums\MembershipTypeEnum;
use Database\Factories\MemberFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Override;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Member Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $proto_username
 * @property string|null $membership_form_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_primary_at_another_association
 * @property int|null $until
 * @property Carbon|null $deleted_at
 * @property string|null $card_printed_on
 * @property int|null $omnomcom_sound_id
 * @property MembershipTypeEnum $membership_type
 * @property-read UtAccount|null $UtAccount
 * @property-read StorageEntry|null $customOmnomcomSound
 * @property-read StorageEntry|null $membershipForm
 * @property-read User|null $user
 *
 * @method static MemberFactory factory($count = null, $state = [])
 * @method static Builder<static>|Member newModelQuery()
 * @method static Builder<static>|Member newQuery()
 * @method static Builder<static>|Member onlyTrashed()
 * @method static Builder<static>|Member primary()
 * @method static Builder<static>|Member query()
 * @method static Builder<static>|Member whereCardPrintedOn($value)
 * @method static Builder<static>|Member whereCreatedAt($value)
 * @method static Builder<static>|Member whereDeletedAt($value)
 * @method static Builder<static>|Member whereId($value)
 * @method static Builder<static>|Member whereIsPrimaryAtAnotherAssociation($value)
 * @method static Builder<static>|Member whereMembershipFormId($value)
 * @method static Builder<static>|Member whereMembershipType($value)
 * @method static Builder<static>|Member whereOmnomcomSoundId($value)
 * @method static Builder<static>|Member whereProtoUsername($value)
 * @method static Builder<static>|Member whereUntil($value)
 * @method static Builder<static>|Member whereUpdatedAt($value)
 * @method static Builder<static>|Member whereUserId($value)
 * @method static Builder<static>|Member withTrashed()
 * @method static Builder<static>|Member withoutTrashed()
 *
 * @mixin Eloquent
 */
class Member extends Model implements HasMedia
{
    /** @use HasFactory<MemberFactory>*/
    use HasFactory;

    use SoftDeletes;

    use InteractsWithMedia;

    protected $table = 'members';

    protected $guarded = ['id', 'user_id'];

    #[Override]
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'deleted_at' => 'datetime',
            'membership_type' => MembershipTypeEnum::class,
            'is_primary_at_another_association' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('omnnomcom_sound')
            ->useDisk('public')
            ->acceptsMimeTypes(['audio/mpeg'])
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function membershipForm(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'membership_form_id');
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function customOmnomcomSound(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'omnomcom_sound_id');
    }

    /**
     * @return HasOne<UtAccount, $this>
     */
    public function UtAccount(): HasOne
    {
        return $this->hasOne(UtAccount::class);
    }

    /** @param Builder<$this> $query
     * @return Builder<$this>
     */
    protected function scopePrimary(Builder $query): Builder
    {
        return $query->whereMembershipType(MembershipTypeEnum::REGULAR)
            ->where('is_primary_at_another_association', false)
            ->whereHas('UtAccount');
    }

    public static function countActiveMembers(): int
    {
        return User::query()->whereHas('committees')->count();
    }

    public static function countPendingMembers(): int
    {
        return User::query()->whereHas('member', static function ($query) {
            $query->whereMembershipType(MembershipTypeEnum::PENDING);
        })->count();
    }

    public static function countValidMembers(): int
    {
        return User::query()->whereHas('member', static function ($query) {
            $query->whereNot('membership_type', MembershipTypeEnum::PENDING);
        })->count();
    }

    public function getMembershipOrderline(): ?OrderLine
    {
        $year_start = intval(Carbon::now()->format('n')) >= 9 ? intval(Carbon::now()->format('Y')) : intval(Carbon::now()->format('Y')) - 1;

        return OrderLine::query()
            ->whereIn('product_id', array_values(Config::array('omnomcom.fee')))
            ->where('created_at', '>=', $year_start.'-09-01 00:00:01')
            ->where('user_id', '=', $this->user->id)
            ->first();
    }

    public function getMemberType(?OrderLine $membershipOrderline = null): ?string
    {
        if ($membershipOrderline != null) {
            return match ($membershipOrderline->product->id) {
                Config::integer('omnomcom.fee.regular') => 'primary',
                Config::integer('omnomcom.fee.reduced') => 'secondary',
                Config::integer('omnomcom.fee.remitted') => 'non-paying',
                default => 'unknown',
            };
        }

        return null;
    }

    /**
     * Create an email alias friendly username from a full name.
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
