<?php

namespace Proto\Models;

use Carbon;
use DateTime;
use DirectAdmin\DirectAdmin;
use Eloquent;
use Exception;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Proto\Console\Commands\DirectAdminSync;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * User Model.
 *
 * @property int $id
 * @property string $name
 * @property string $calling_name
 * @property string $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $birthdate
 * @property string|null $phone
 * @property string|null $diet
 * @property string|null $website
 * @property int $phone_visible
 * @property int $address_visible
 * @property int $receive_sms
 * @property int $keep_protube_history
 * @property int $show_birthday
 * @property int $show_achievements
 * @property int $profile_in_almanac
 * @property int $show_omnomcom_total
 * @property int $show_omnomcom_calories
 * @property int $keep_omnomcom_history
 * @property int $disable_omnomcom
 * @property string $theme
 * @property int|null $pref_calendar_alarm
 * @property int $pref_calendar_relevant_only
 * @property string|null $utwente_username
 * @property string|null $edu_username
 * @property string|null $utwente_department
 * @property int $did_study_create
 * @property int $did_study_itech
 * @property string|null $tfa_totp_key
 * @property int $signed_nda
 * @property Carbon|null $deleted_at
 * @property string|null $personal_key
 * @property-read Collection|Achievement[] $achievements
 * @property-read Address $address
 * @property-read Bank $bank
 * @property-read Collection|Client[] $clients
 * @property-read mixed $completed_profile
 * @property-read mixed $is_member
 * @property-read mixed $is_protube_admin
 * @property-read mixed $photo_preview
 * @property-read mixed $signed_membership_form
 * @property-read mixed $welcome_message
 * @property-read HelperReminder $helperReminderSubscriptions
 * @property-read Collection|EmailList[] $lists
 * @property-read Member $member
 * @property-read Collection|MollieTransaction[] $mollieTransactions
 * @property-read Collection|OrderLine[] $orderlines
 * @property-read StorageEntry|null $photo
 * @property-read Collection|PlayedVideo[] $playedVideos
 * @property-read Collection|Quote[] $quotes
 * @property-read Collection|RfidCard[] $rfid
 * @property-read Collection|Role[] $roles
 * @property-read Collection|Tempadmin[] $tempadmin
 * @property-read Collection|Token[] $tokens
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static QueryBuilder|User onlyTrashed()
 * @method static QueryBuilder|User withTrashed()
 * @method static QueryBuilder|User withoutTrashed()
 * @method static Builder|User whereAddressVisible($value)
 * @method static Builder|User whereBirthdate($value)
 * @method static Builder|User whereCallingName($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDidStudyCreate($value)
 * @method static Builder|User whereDidStudyItech($value)
 * @method static Builder|User whereDiet($value)
 * @method static Builder|User whereDisableOmnomcom($value)
 * @method static Builder|User whereEduUsername($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereImageId($value)
 * @method static Builder|User whereKeepOmnomcomHistory($value)
 * @method static Builder|User whereKeepProtubeHistory($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePersonalKey($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePhoneVisible($value)
 * @method static Builder|User wherePrefCalendarAlarm($value)
 * @method static Builder|User wherePrefCalendarRelevantOnly($value)
 * @method static Builder|User whereProfileInAlmanac($value)
 * @method static Builder|User whereReceiveSms($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereShowAchievements($value)
 * @method static Builder|User whereShowBirthday($value)
 * @method static Builder|User whereShowOmnomcomCalories($value)
 * @method static Builder|User whereShowOmnomcomTotal($value)
 * @method static Builder|User whereSignedNda($value)
 * @method static Builder|User whereTfaTotpKey($value)
 * @method static Builder|User whereTheme($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUtwenteDepartment($value)
 * @method static Builder|User whereUtwenteUsername($value)
 * @method static Builder|User whereWebsite($value)
 * @mixin Eloquent
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes, HasApiTokens;

    protected $table = 'users';

    protected $guarded = ['password', 'remember_token'];

    protected $appends = ['is_member', 'photo_preview', 'welcome_message', 'is_protube_admin'];

    protected $hidden = ['password', 'remember_token', 'personal_key', 'deleted_at', 'created_at', 'image_id', 'tfa_totp_key', 'updated_at', 'diet'];

    protected $dates = ['deleted_at'];

    /** @return string|null */
    public function getPublicId()
    {
        return $this->is_member ? $this->member->proto_username : null;
    }

    /**
     * @param string $public_id
     * @return mixed|User|null
     */
    public static function fromPublicId($public_id)
    {
        $member = Member::where('proto_username', $public_id)->first();
        return $member ? $member->user : null;
    }

    /**
     * **IMPORTANT!** IF YOU ADD ANY RELATION TO A USER IN ANOTHER MODEL, DON'T FORGET TO UPDATE THIS METHOD.
     * @return bool whether or not the user is stale (not in use, can be really deleted safely).
     */
    public function isStale()
    {
        return
            $this->password &&
            $this->edu_username &&
            strtotime($this->created_at) > strtotime('-1 hour') &&
            Member::withTrashed()->where('user_id', $this->id)->first() &&
            Bank::where('user_id', $this->id)->first() &&
            Address::where('user_id', $this->id)->first() &&
            OrderLine::where('user_id', $this->id)->count() > 0 &&
            CommitteeMembership::withTrashed()->where('user_id', $this->id)->count() > 0 &&
            Quote::where('user_id', $this->id)->count() > 0 &&
            EmailListSubscription::where('user_id', $this->id)->count() > 0 &&
            RfidCard::where('user_id', $this->id)->count() > 0 &&
            PlayedVideo::where('user_id', $this->id)->count() > 0 &&
            AchievementOwnership::where('user_id', $this->id)->count() > 0;
    }

    /** @return BelongsTo|StorageEntry User's profile picture */
    public function photo()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    /** @return BelongsTo|HelperReminder */
    public function helperReminderSubscriptions()
    {
        return $this->belongsTo('Proto\Models\HelperReminder');
    }

    /** @return BelongsToMany|Role[] */
    public function roles()
    {
        return $this->belongsToMany('Proto\Models\Role', 'role_user');
    }

    /** @return BelongsToMany|Committee[] */
    private function getGroups()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_users')
            ->where(function ($query) {
                $query->whereNull('committees_users.deleted_at')
                    ->orWhere('committees_users.deleted_at', '>', Carbon::now());
            })
            ->where('committees_users.created_at', '<', Carbon::now())
            ->withPivot(['id', 'role', 'edition', 'created_at', 'deleted_at'])
            ->withTimestamps()
            ->orderBy('pivot_created_at', 'desc');
    }

    /** @return BelongsToMany|EmailList[] */
    public function lists()
    {
        return $this->belongsToMany('Proto\Models\EmailList', 'users_mailinglists', 'user_id', 'list_id');
    }

    /** @return BelongsToMany|Achievement[] */
    public function achievements()
    {
        return $this->belongsToMany('Proto\Models\Achievement', 'achievements_users')->withPivot(['id'])->withTimestamps()->orderBy('pivot_created_at', 'desc');
    }

    /** @return BelongsToMany|Committee[] */
    public function committees()
    {
        return $this->getGroups()->where('is_society', false);
    }

    /** @return BelongsToMany|Committee[] */
    public function societies()
    {
        return $this->getGroups()->where('is_society', true);
    }

    /** @return HasOne|Member */
    public function member()
    {
        return $this->hasOne('Proto\Models\Member');
    }

    /** @return HasOne|Bank */
    public function bank()
    {
        return $this->hasOne('Proto\Models\Bank');
    }

    /** @return HasOne|Address */
    public function address()
    {
        return $this->hasOne('Proto\Models\Address');
    }

    /** @return HasMany|OrderLine[] */
    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine');
    }

    /** @return HasMany|Tempadmin[] */
    public function tempadmin()
    {
        return $this->hasMany('Proto\Models\Tempadmin');
    }

    /** @return HasMany|Quote[] */
    public function quotes()
    {
        return $this->hasMany('Proto\Models\Quote');
    }

    /** @return HasMany|RfidCard[] */
    public function rfid()
    {
        return $this->hasMany('Proto\Models\RfidCard');
    }

    /** @return HasMany|Token[] */
    public function tokens()
    {
        return $this->hasMany('Proto\Models\Token');
    }

    /** @return HasMany|PlayedVideo[] */
    public function playedVideos()
    {
        return $this->hasMany('Proto\Models\PlayedVideo');
    }

    /** @return HasMany|MollieTransaction[] */
    public function mollieTransactions()
    {
        return $this->hasMany('Proto\Models\MollieTransaction');
    }

    /**
     * Use this method instead of $user->photo->generate to bypass the "no profile" problem.
     * @param int $w
     * @param int $h
     * @return string Path to a resized version of someone's profile picture.
     */
    public function generatePhotoPath($w = 100, $h = 100)
    {
        if ($this->photo) {
            return $this->photo->generateImagePath($w, $h);
        } else {
            return asset('images/default-avatars/other.png');
        }
    }

    /**
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        // Update Laravel Password
        $this->password = Hash::make($password);
        $this->save();

        // Update DirectAdmin Password
        if ($this->is_member) {
            $da = new DirectAdmin;
            $da->connect(getenv('DA_HOSTNAME'), getenv('DA_PORT'));
            $da->set_login(getenv('DA_USERNAME'), getenv('DA_PASSWORD'));

            $da->set_method('post');
            $q = DirectAdminSync::constructQuery('CMD_API_POP', [
                'action' => 'modify',
                'domain' => env('DA_DOMAIN'),
                'user' => $this->member->proto_username,
                'newuser' => $this->member->proto_username,
                'passwd' => $password,
                'passwd2' => $password,
                'quota' => 0, // Unlimited
                'limit' => 0, // Unlimited
            ]);
            $da->query($q);
        }

        // Remove breach notification flag
        HashMapItem::where('key', 'pwned-pass')->where('subkey', $this->id)->delete();
    }

    /** @return bool */
    public function hasUnpaidOrderlines()
    {
        foreach ($this->orderlines as $orderline) {
            if (! $orderline->isPayed()) {
                return true;
            }
            if ($orderline->withdrawal && $orderline->withdrawal->id !== 1 && ! $orderline->withdrawal->closed) {
                return true;
            }
        }
        return false;
    }

    /** @return bool */
    public function isTempadmin()
    {
        foreach ($this->tempadmin as $tempadmin) {
            if (Carbon::now()->between(Carbon::parse($tempadmin->start_at), Carbon::parse($tempadmin->end_at))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function age()
    {
        return Carbon::instance(new DateTime($this->birthdate))->age;
    }

    /**
     * @param Committee $committee
     * @return bool
     */
    public function isInCommittee($committee)
    {
        return in_array($this->id, $committee->users->pluck('id')->toArray());
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function isInCommitteeBySlug($slug)
    {
        $committee = Committee::where('slug', $slug)->first();
        return $committee && $this->isInCommittee($committee);
    }

    /** @return bool */
    public function isActiveMember()
    {
        return count(CommitteeMembership::withTrashed()
                ->where('user_id', $this->id)
                ->where('created_at', '<', date('Y-m-d H:i:s'))
                ->where(function ($q) {
                    $q->whereNull('deleted_at')
                        ->orWhere('deleted_at', '>', date('Y-m-d H:i:s'));
                })
                ->with('committee')
                ->get()
                ->where('committee.is_society', false)
            ) > 0;
    }

    /** @return Achievement[] */
    public function achieved()
    {
        $achievements = $this->achievements;
        $acquired = [];
        foreach ($achievements as $achievement) {
            $acquired[] = $achievement;
        }
        return $acquired;
    }

    /**
     * @param int $limit
     * @return WithDrawal[]
     */
    public function withdrawals($limit = 0)
    {
        $withdrawals = [];
        foreach (Withdrawal::orderBy('date', 'desc')->get() as $withdrawal) {
            if ($withdrawal->orderlinesForUser($this)->count() > 0) {
                $withdrawals[] = $withdrawal;
                if ($limit > 0 && count($withdrawals) > $limit) {
                    break;
                }
            }
        }
        return $withdrawals;
    }

    /** @return string|null*/
    public function websiteUrl()
    {
        if (preg_match("/(?:http|https):\/\/.*/i", $this->website) === 1) {
            return $this->website;
        } else {
            return 'https://'.$this->website;
        }
    }

    /** @return string|null*/
    public function websiteDisplay()
    {
        if (preg_match("/(?:http|https):\/\/(.*)/i", $this->website, $matches) === 1) {
            return $matches[1];
        } else {
            return $this->website;
        }
    }

    /** @return bool */
    public function hasDiet()
    {
        return strlen(str_replace(["\r", "\n", ' '], '', $this->diet)) > 0;
    }

    /** @return string*/
    public function getDisplayEmail()
    {
        return ($this->is_member && $this->isActiveMember()) ? sprintf('%s@%s', $this->member->proto_username, config('proto.emaildomain')) : $this->email;
    }

    /**
     * This method returns a guess of the system for whether or not this user is a first year student.
     * Note that this is a _GUESS_. There is no way for us to know sure without manually setting a flag on each user.
     * @return bool Whether or not the system thinks this is a first year.
     * @throws Exception
     */
    public function isFirstYear()
    {
        return $this->is_member
            && Carbon::instance(new DateTime($this->member->created_at))->age < 1
            && $this->did_study_create;
    }

    /** @return bool */
    public function hasTFAEnabled()
    {
        return $this->tfa_totp_key !== null;
    }

    public function generateNewPersonalKey()
    {
        $this->personal_key = str_random(64);
        $this->save();
    }

    /** @return string */
    public function getPersonalKey()
    {
        if ($this->personal_key == null) {
            $this->generateNewPersonalKey();
        }
        return $this->personal_key;
    }

    /** @return Token */
    public function generateNewToken()
    {
        $token = new Token();
        $token->generate($this);
        return $token;
    }

    /** @return Token */
    public function getToken()
    {
        if (count($this->tokens) > 0) {
            $token = $this->tokens->last();
        } else {
            $token = $this->generateNewToken();
        }
        $token->touch();
        return $token;
    }

    /** Removes user's birthdate and phone number. */
    public function clearMemberProfile()
    {
        $this->birthdate = null;
        $this->phone = null;
        $this->save();
    }

    /** @return Member[] */
    public function getMemberships()
    {
        $memberships['pending'] = Member::withTrashed()->where('user_id', '=', $this->id)->where('deleted_at', '=', null)->where('pending', '=', true)->get();
        $memberships['previous'] = Member::withTrashed()->where('user_id', '=', $this->id)->where('deleted_at', '!=', null)->get();
        return $memberships;
    }

    /** @return int|null */
    public function getCalendarAlarm()
    {
        return $this->pref_calendar_alarm;
    }

    /** @param $hours */
    public function setCalendarAlarm($hours)
    {
        $hours = floatval($hours);
        $this->pref_calendar_alarm = ($hours > 0 ? $hours : null);
        $this->save();
    }

    /** @return int */
    public function getCalendarRelevantSetting()
    {
        return $this->pref_calendar_relevant_only;
    }

    public function toggleCalendarRelevantSetting()
    {
        $this->pref_calendar_relevant_only = ! $this->pref_calendar_relevant_only;
        $this->save();
    }

    /** @return bool */
    public function getCompletedProfileAttribute()
    {
        return $this->birthdate !== null && $this->phone !== null;
    }

    /** @return bool Whether user has a current membership that is not pending. */
    public function getIsMemberAttribute()
    {
        return $this->member && ! $this->member->pending;
    }

    /** @return bool */
    public function getSignedMembershipFormAttribute()
    {
        return $this->member && $this->member->membershipForm !== null;
    }

    /** @return bool */
    public function getIsProtubeAdminAttribute()
    {
        return $this->can('protube') || $this->isTempadmin();
    }

    /** @return string */
    public function getPhotoPreviewAttribute()
    {
        return $this->generatePhotoPath();
    }

    /** @return string */
    public function getIcalUrl()
    {
        return route('ical::calendar', ['personal_key' => $this->getPersonalKey()]);
    }

    /** @return string|null */
    public function getWelcomeMessageAttribute()
    {
        $welcomeMessage = WelcomeMessage::where('user_id', $this->id)->first();
        if ($welcomeMessage) {
            return $welcomeMessage->message;
        } else {
            return null;
        }
    }
}
