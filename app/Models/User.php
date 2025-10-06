<?php

namespace App\Models;

use App\Enums\MembershipTypeEnum;
use App\Http\Controllers\EmailListController;
use App\Mail\PasswordResetEmail;
use App\Mail\RegistrationConfirmation;
use App\Mail\UsernameReminderEmail;
use Database\Factories\UserFactory;
use Eloquent;
use Exception;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * User Model.
 *
 * @property int $id
 * @property string $name
 * @property string $calling_name
 * @property string $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $last_seen_at
 * @property string|null $birthdate
 * @property string|null $phone
 * @property string|null $diet
 * @property string|null $website
 * @property bool $phone_visible
 * @property bool $address_visible
 * @property bool $receive_sms
 * @property bool $keep_protube_history
 * @property float|null $pref_calendar_alarm
 * @property bool $show_birthday
 * @property bool $show_achievements
 * @property bool $profile_in_almanac
 * @property bool $show_omnomcom_total
 * @property bool $show_omnomcom_calories
 * @property bool $keep_omnomcom_history
 * @property bool $disable_omnomcom
 * @property int $theme
 * @property bool $pref_calendar_relevant_only
 * @property string|null $utwente_username
 * @property string|null $edu_username
 * @property string|null $utwente_department
 * @property bool $did_study_create
 * @property bool $did_study_itech
 * @property string|null $tfa_totp_key
 * @property bool $signed_nda
 * @property Carbon|null $deleted_at
 * @property string|null $personal_key
 * @property string|null $discord_id
 * @property-read Collection<int, Achievement> $achievements
 * @property-read int|null $achievements_count
 * @property-read Address|null $address
 * @property-read Bank|null $bank
 * @property-read Collection<int, Client> $clients
 * @property-read int|null $clients_count
 * @property-read Collection<int, Committee> $committees
 * @property-read int|null $committees_count
 * @property-read bool $completed_profile
 * @property-read Collection<int, Feedback> $feedback
 * @property-read int|null $feedback_count
 * @property-read string|null $welcome_message
 * @property-read Collection<int, Committee> $groups
 * @property-read int|null $groups_count
 * @property-read bool $is_member
 * @property-read Collection<int, EmailList> $lists
 * @property-read int|null $lists_count
 * @property-read Member|null $member
 * @property-read Collection<int, MollieTransaction> $mollieTransactions
 * @property-read int|null $mollie_transactions_count
 * @property-read Collection<int, OrderLine> $orderlines
 * @property-read int|null $orderlines_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, PlayedVideo> $playedVideos
 * @property-read int|null $played_videos_count
 * @property-read mixed $proto_email
 * @property-read Collection<int, RfidCard> $rfid
 * @property-read int|null $rfid_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read bool $signed_membership_form
 * @property-read Collection<int, Committee> $societies
 * @property-read int|null $societies_count
 * @property-read Collection<int, Sticker> $stickers
 * @property-read int|null $stickers_count
 * @property-read Collection<int, Tempadmin> $tempadmin
 * @property-read int|null $tempadmin_count
 * @property-read Collection<int, Ticket> $tickets
 * @property-read int|null $tickets_count
 * @property-read WelcomeMessage|null $welcomeMessage
 * @property-read Collection<int, Withdrawal> $withdrawals
 * @property-read int|null $withdrawals_count
 * @property-read int|null $stickers_country_count
 * @property-read bool|null $has_stickers
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User whereAddressVisible($value)
 * @method static Builder<static>|User whereBirthdate($value)
 * @method static Builder<static>|User whereCallingName($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereDeletedAt($value)
 * @method static Builder<static>|User whereDidStudyCreate($value)
 * @method static Builder<static>|User whereDidStudyItech($value)
 * @method static Builder<static>|User whereDiet($value)
 * @method static Builder<static>|User whereDisableOmnomcom($value)
 * @method static Builder<static>|User whereDiscordId($value)
 * @method static Builder<static>|User whereEduUsername($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereKeepOmnomcomHistory($value)
 * @method static Builder<static>|User whereKeepProtubeHistory($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User wherePersonalKey($value)
 * @method static Builder<static>|User wherePhone($value)
 * @method static Builder<static>|User wherePhoneVisible($value)
 * @method static Builder<static>|User wherePrefCalendarAlarm($value)
 * @method static Builder<static>|User wherePrefCalendarRelevantOnly($value)
 * @method static Builder<static>|User whereProfileInAlmanac($value)
 * @method static Builder<static>|User whereReceiveSms($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereShowAchievements($value)
 * @method static Builder<static>|User whereShowBirthday($value)
 * @method static Builder<static>|User whereShowOmnomcomCalories($value)
 * @method static Builder<static>|User whereShowOmnomcomTotal($value)
 * @method static Builder<static>|User whereSignedNda($value)
 * @method static Builder<static>|User whereTfaTotpKey($value)
 * @method static Builder<static>|User whereTheme($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereUtwenteDepartment($value)
 * @method static Builder<static>|User whereUtwenteUsername($value)
 * @method static Builder<static>|User whereWebsite($value)
 * @method static Builder<static>|User withTrashed()
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @method static Builder<static>|User withoutTrashed()
 *
 * @mixin Eloquent
 */
class User extends Authenticatable implements AuthenticatableContract, CanResetPasswordContract, HasMedia
{
    use CanResetPassword;
    use HasApiTokens;

    /** @use HasFactory<UserFactory>*/
    use HasFactory;

    use HasRoles;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'users';

    protected $guarded = ['password', 'remember_token'];

    protected $with = ['member'];

    protected $appends = ['is_member'];

    protected $hidden = ['password', 'remember_token', 'personal_key', 'deleted_at', 'created_at', 'tfa_totp_key', 'updated_at', 'diet'];

    public function getPublicId(): ?string
    {
        return $this->is_member ? $this->member->proto_username : null;
    }

    public static function fromPublicId(string $public_id): ?User
    {
        return User::query()->whereHas('member', static function ($query) use ($public_id) {
            $query->where('proto_username', $public_id);
        })->first();
    }

    /**
     * **IMPORTANT!** IF YOU ADD ANY RELATION TO A USER IN ANOTHER MODEL, DON'T FORGET TO UPDATE THIS METHOD.
     *
     * @return bool whether the user is stale (not in use, can really be deleted safely).
     */
    public function isStale(): bool
    {
        return ! (
            $this->password ||
            $this->edu_username ||
            Carbon::parse($this->created_at)->timestamp > Carbon::now()->subHour()->timestamp ||
            Member::withTrashed()->where('user_id', $this->id)->first() ||
            Bank::query()->where('user_id', $this->id)->first() ||
            Address::query()->where('user_id', $this->id)->first() ||
            OrderLine::query()->where('user_id', $this->id)->count() > 0 ||
            CommitteeMembership::withTrashed()->where('user_id', $this->id)->count() > 0 ||
            Feedback::query()->where('user_id', $this->id)->count() > 0 ||
            EmailListSubscription::query()->where('user_id', $this->id)->count() > 0 ||
            RfidCard::query()->where('user_id', $this->id)->count() > 0 ||
            PlayedVideo::query()->where('user_id', $this->id)->count() > 0 ||
            AchievementOwnership::query()->where('user_id', $this->id)->count() > 0
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->useDisk(App::environment('local') ? 'public' : 'stack')
            ->storeConversionsOnDisk('public')
            ->useFallbackUrl(asset('images/default-avatars/other.png'))
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->performOnCollections('profile_picture')
            ->nonQueued()
            ->fit(Fit::Crop, 250, 250)
            ->format('webp');

        $this->addMediaConversion('thumb')
            ->performOnCollections('profile_picture')
            ->nonQueued()
            ->fit(Fit::Crop, 25, 25)
            ->format('webp');
    }

    /**
     * @return BelongsToMany<Committee, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Committee::class, 'committees_users')
            ->where(static function ($query) {
                $query->whereNull('committees_users.deleted_at')
                    ->orWhere('committees_users.deleted_at', '>', Carbon::now());
            })
            ->where('committees_users.created_at', '<', Carbon::now())
            ->withPivot(['id', 'role', 'edition'])
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * @return BelongsToMany<EmailList, $this>
     */
    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(EmailList::class, 'users_mailinglists', 'user_id', 'list_id');
    }

    /**
     * @return BelongsToMany<Achievement, $this>
     */
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'achievements_users')->withPivot(['id', 'description'])->withTimestamps()->orderByPivot('created_at', 'desc');
    }

    /**
     * @return BelongsToMany<Ticket, $this>
     */
    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_purchases')->withPivot('id', 'created_at')->withTimestamps();
    }

    /**
     * @return BelongsToMany<Committee, $this>
     */
    public function committees(): BelongsToMany
    {
        return $this->groups()->where('is_society', false);
    }

    /**
     * @return BelongsToMany<Committee, $this>
     */
    public function societies(): BelongsToMany
    {
        return $this->groups()->where('is_society', true);
    }

    /**
     * @return BelongsToMany<Activity, $this, Pivot>
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activities_users')
            ->whereNull('activities_users.deleted_at')
            ->where('backup', false)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<Activity, $this, Pivot>
     */
    public function backupActivities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activities_users')
            ->whereNull('activities_users.deleted_at')
            ->where('backup', true)
            ->withTimestamps();
    }

    /**
     * @return HasOne<Bank, $this>
     */
    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class);
    }

    /**
     * @return HasOne<Address, $this>
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return HasOne<Member, $this>
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    /**
     * @return HasOne<WelcomeMessage, $this>
     */
    public function welcomeMessage(): HasOne
    {
        return $this->hasOne(WelcomeMessage::class);
    }

    /**
     * @return HasMany<OrderLine, $this>
     */
    public function orderlines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    /**
     * @return HasMany<Tempadmin, $this>
     */
    public function tempadmin(): HasMany
    {
        return $this->hasMany(Tempadmin::class);
    }

    /**
     * @return HasMany<Feedback, $this>
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return HasMany<RfidCard, $this>
     */
    public function rfid(): HasMany
    {
        return $this->hasMany(RfidCard::class);
    }

    /**
     * @return HasMany<PlayedVideo, $this>
     */
    public function playedVideos(): HasMany
    {
        return $this->hasMany(PlayedVideo::class);
    }

    /**
     * @return HasMany<MollieTransaction, $this>
     */
    public function mollieTransactions(): HasMany
    {
        return $this->hasMany(MollieTransaction::class);
    }

    /**
     * @return HasMany<Sticker, $this>
     */
    public function stickers(): HasMany
    {
        return $this->hasMany(Sticker::class);
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        // Update Laravel Password
        $this->password = Hash::make($password);
        $this->save();

        // Remove breach notification flag
        HashMapItem::query()->where('key', 'pwned-pass')->where('subkey', $this->id)->delete();
    }

    public function hasUnpaidOrderlines(): bool
    {
        return $this->orderlines()->unpayed()->exists();
    }

    /**
     * Returns whether the user is currently tempadmin.
     */
    public function isTempadmin(): bool
    {
        return $this->tempadmin()->where('start_at', '<', Carbon::now())->where('end_at', '>', Carbon::now())->exists();
    }

    /**
     * Returns whether the user is tempadmin between now and the end of the day.
     */
    public function isTempadminLaterToday(): bool
    {
        return $this->tempadmin()->where('start_at', '<', Carbon::now()->endOfDay())->where('end_at', '<', Carbon::now())->exists();
    }

    /**
     * @throws Exception
     */
    public function age(): int
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function isInCommittee(Committee $committee): bool
    {
        return $committee->users()->where('user_id', $this->id)->exists();
    }

    public function isActiveMember(): bool
    {
        return $this->committees()->exists();
    }

    /**
     * @return HasManyThrough<Withdrawal, OrderLine, $this>
     */
    public function withdrawals(): HasManyThrough
    {
        return $this->hasManyThrough(Withdrawal::class, OrderLine::class, 'user_id', 'id', 'id', 'payed_with_withdrawal')
            ->groupBy('withdrawals.id')
            ->orderBy('withdrawals.created_at', 'desc');
    }

    public function websiteUrl(): ?string
    {
        if (preg_match("/(?:http|https):\/\/.*/i", $this->website) === 1) {
            return $this->website;
        }

        return 'https://'.$this->website;
    }

    public function websiteDisplay(): ?string
    {
        if (preg_match("/(?:http|https):\/\/(.*)/i", $this->website, $matches) === 1) {
            return $matches[1];
        }

        return $this->website;
    }

    public function hasDiet(): bool
    {
        return strlen(str_replace(["\r", "\n", ' '], '', $this->diet)) > 0;
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function protoEmail(): Attribute
    {
        return Attribute::make(get: fn () => $this->is_member && $this->groups->isNotEmpty() ? $this->member->proto_username.'@'.config('proto.emaildomain') : null);
    }

    public function getDisplayEmail(): string
    {
        return $this->proto_email ?? $this->email;
    }

    /**
     * This method returns a guess of the system for whether this user is a first year student.
     * Note that this is a _GUESS_. There is no way for us to know sure without manually setting a flag on each user.
     *
     * @return bool Whether the system thinks the user is a first year.
     */
    public function isFirstYear(): bool
    {
        return $this->is_member
            && Carbon::createFromTimestamp($this->member->created_at, date_default_timezone_get())->age < 1
            && $this->did_study_create;
    }

    public function hasTFAEnabled(): bool
    {
        return $this->tfa_totp_key !== null;
    }

    public function generateNewPersonalKey(): void
    {
        $this->personal_key = Str::random(64);
        $this->save();
    }

    public function getPersonalKey(): ?string
    {
        if ($this->personal_key == null) {
            $this->generateNewPersonalKey();
        }

        return $this->personal_key;
    }

    /** Removes user's birthdate and phone number. */
    public function clearMemberProfile(): void
    {
        $this->birthdate = null;
        $this->phone = null;
        $this->save();
    }

    /** @return array<string, Collection<int, Member>> */
    public function getMemberships(): array
    {
        $memberships['pending'] = Member::withTrashed()->where('user_id', '=', $this->id)->whereNull('deleted_at')->whereMembershipType(MembershipTypeEnum::PENDING)->get();
        $memberships['previous'] = Member::withTrashed()->where('user_id', '=', $this->id)->whereNotNull('deleted_at')->get();

        return $memberships;
    }

    public function getCalendarAlarm(): ?float
    {
        return $this->pref_calendar_alarm;
    }

    public function setCalendarAlarm(?float $hours): void
    {
        $hours = floatval($hours);
        $this->pref_calendar_alarm = ($hours > 0 ? $hours : null);
        $this->save();
    }

    public function getCalendarRelevantSetting(): bool
    {
        return $this->pref_calendar_relevant_only;
    }

    public function toggleCalendarRelevantSetting(): void
    {
        $this->pref_calendar_relevant_only = ! $this->pref_calendar_relevant_only;
        $this->save();
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function completedProfile(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->birthdate !== null && $this->phone !== null);
    }

    /**
     * @return Attribute<bool, never> Whether user has a current membership that is not pending.
     */
    protected function isMember(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->member && $this->member->membership_type !== MembershipTypeEnum::PENDING);
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function signedMembershipForm(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->member?->membershipForm !== null);
    }

    public function getIcalUrl(): string
    {
        return route('ical::calendar', ['personal_key' => $this->getPersonalKey()]);
    }

    /**
     * Register a new user.
     * This method will send a confirmation email and a password reset email.
     * The user will be subscribed to the default email lists.
     */
    public static function register(string $email, string $callingName, string $fullName, ?string $utwenteId = null, ?string $utwenteEmail = null): User
    {
        $user = User::query()->create([
            'email' => $email,
            'calling_name' => $callingName,
            'name' => $fullName,
            'utwente_username' => $utwenteId,
            'edu_username' => $utwenteEmail,
        ]);

        Mail::to($user)->queue((new RegistrationConfirmation($user))->onQueue('high'));

        $user->sendPasswordResetEmail();

        EmailListController::autoSubscribeToLists('autoSubscribeUser', $user);

        return $user;
    }

    /**
     * Send a password reset email to this user.
     */
    public function sendPasswordResetEmail(): void
    {
        /** @var PasswordReset $reset */
        $reset = PasswordReset::query()->create([
            'email' => $this->email,
            'token' => Str::random(128),
            'valid_to' => Carbon::now()->addHour()->timestamp,
        ]);

        Mail::to($this)->queue((new PasswordResetEmail($this, $reset->token))->onQueue('high'));
    }

    /**
     * Email this user with their username.
     */
    public function sendForgotUsernameEmail(): void
    {
        Mail::to($this)->queue((new UsernameReminderEmail($this))->onQueue('high'));
    }

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'phone_visible' => 'boolean',
            'address_visible' => 'boolean',
            'pref_calendar_relevant_only' => 'boolean',
            'profile_in_almanac' => 'boolean',
            'receive_sms' => 'boolean',
            'disable_omnomcom' => 'boolean',
            'keep_omnomcom_history' => 'boolean',
            'keep_protube_history' => 'boolean',
            'show_achievements' => 'boolean',
            'show_birthday' => 'boolean',
            'show_omnomcom_calories' => 'boolean',
            'show_omnomcom_total' => 'boolean',
            'signed_nda' => 'boolean',
            'did_study_create' => 'boolean',
            'did_study_itech' => 'boolean',
        ];
    }
}
