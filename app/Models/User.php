<?php

namespace Proto\Models;

use Proto\Models\HashMapItem;

use Adldap\Adldap;
use Adldap\Connections\Provider;
use Adldap\Objects\AccountControl;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DateTime;
use Carbon\Carbon;
use Hash;

use Zizaco\Entrust\Traits\EntrustUserTrait;

use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package Proto\Models
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes, HasApiTokens;
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $guarded = ['password', 'remember_token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'password', 'remember_token', 'personal_key', 'deleted_at', 'created_at', 'image_id', 'tfa_totp_key', 'updated_at'];

    public function getPublicId()
    {
        return ($this->member ? $this->member->proto_username : null);
    }

    public static function fromPublicId($public_id)
    {
        $member = Member::where('proto_username', $public_id)->first();
        return ($member ? $member->user : null);
    }

    /**
     * IMPORTANT!!! IF YOU ADD ANY RELATION TO A USER IN ANOTHER MODEL, DON'T FORGET TO UPDATE THIS
     * @return bool whether or not the user is stale (not in use, can be *really* deleted safely)
     */
    public function isStale()
    {
        if ($this->password) return false;
        if ($this->edu_username) return false;
        if (strtotime($this->created_at) > strtotime('-1 hour')) return false;
        if (Member::withTrashed()->where('user_id', $this->id)->first()) return false;
        if (Bank::where('user_id', $this->id)->first()) return false;
        if (Address::where('user_id', $this->id)->first()) return false;
        if (OrderLine::where('user_id', $this->id)->count() > 0) return false;
        if (CommitteeMembership::withTrashed()->where('user_id', $this->id)->count() > 0) return false;
        if (Quote::where('user_id', $this->id)->count() > 0) return false;
        if (EmailListSubscription::where('user_id', $this->id)->count() > 0) return false;
        if (RfidCard::where('user_id', $this->id)->count() > 0) return false;
        if (PlayedVideo::where('user_id', $this->id)->count() > 0) return false;
        if (AchievementOwnership::where('user_id', $this->id)->count() > 0) return false;
        return true;
    }

    public function roles()
    {
        return $this->belongsToMany('Proto\Models\Role', 'role_user');
    }

    public function setPassword($password)
    {
        // Update Laravel Password
        $this->password = Hash::make($password);
        $this->save();

        if (config('app.env') !== 'local') {
            // Update Active Directory Password
            $ad = new Adldap();
            $provider = new Provider(config('adldap.proto'));
            $ad->addProvider('proto', $provider);
            $ad->connect('proto');

            $ldapuser = $provider->search()->where('objectClass', 'user')->where('description', $this->id)->first();
            if ($ldapuser !== null) {
                $ldapuser->setPassword($password);
                $ldapuser->setUserAccountControl(AccountControl::NORMAL_ACCOUNT);
                $ldapuser->save();
            }
        }

        // Remove breach notification flag
        HashMapItem::where('key', 'pwned-pass')->where('subkey', $this->id)->delete();
    }

    /**
     * @return mixed The associated membership details, if any.
     */
    public function member()
    {
        return $this->hasOne('Proto\Models\Member');
    }

    public function getUtwenteData()
    {
        if ($this->utwente_username) {
            $data = json_decode(file_get_contents(config('app-proto.utwente-ldap-hook') . "?filter=userprincipalname=" . $this->utwente_username . "*"));
            if (count($data) > 0) {
                return (object)$data[0];
            } else {
                return null;
            }
        }
    }

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine');
    }

    public function hasUnpaidOrderlines()
    {
        foreach ($this->orderlines as $orderline) {
            if (!$orderline->isPayed()) return true;
            if ($orderline->withdrawal && $orderline->withdrawal->id !== 1 && !$orderline->withdrawal->closed) return true;
        }
        return false;
    }

    public function tempadmin()
    {
        return $this->hasMany('Proto\Models\Tempadmin');
    }

    public function isTempadmin()
    {
        foreach ($this->tempadmin as $tempadmin) {
            if (Carbon::now()->between(Carbon::parse($tempadmin->start_at), Carbon::parse($tempadmin->end_at))) return true;
        }

        return false;
    }

    /**
     * @return mixed The associated bank authorization, if any.
     */
    public function bank()
    {
        return $this->hasOne('Proto\Models\Bank');
    }

    /**
     * @return mixed The profile picture of this user.
     */
    public function photo()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    /**
     * Returns a sized version of someone's profile photo, use this instead of $user->photo->generate to bypass the no profile problem.
     * @param int $x
     * @param int $y
     * @return mixed
     */
    public function generatePhotoPath($x = 100, $y = 100)
    {
        if ($this->photo) {
            return $this->photo->generateImagePath($x, $y);
        } else {
            return asset('images/default-avatars/other.png');
        }
    }

    /**
     * @return mixed The associated addresses, if any.
     */
    public function address()
    {
        return $this->hasOne('Proto\Models\Address');
    }

    /**
     * @return mixed Returns all committees a user is currently a member of.
     */
    public function committees()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_users')
            ->where(function ($query) {
                $query->whereNull('committees_users.deleted_at')
                    ->orWhere('committees_users.deleted_at', '>', Carbon::now());
            })
            ->where('committees_users.created_at', '<', Carbon::now())
            ->withPivot(array('id', 'role', 'edition', 'created_at', 'deleted_at'))
            ->withTimestamps()
            ->orderBy('pivot_created_at', 'desc');
    }

    /**
     * @return mixed Any quotes the user posted
     */
    public function quotes()
    {
        return $this->hasMany('Proto\Models\Quote');
    }

    public function lists()
    {
        return $this->belongsToMany('Proto\Models\EmailList', 'users_mailinglists', 'user_id', 'list_id');
    }

    /**
     * @return mixed Any cards linked to this account
     */
    public function rfid()
    {
        return $this->hasMany('Proto\Models\RfidCard');
    }

    /**
     * @return mixed Any tokens the user has
     */
    public function tokens()
    {
        return $this->hasMany('Proto\Models\Token');
    }

    /**
     * @return mixed Any videos played by the user.
     */
    public function playedVideos()
    {
        return $this->hasMany('Proto\Models\PlayedVideo');
    }

    /**
     * @return mixed The age in years of a user.
     */
    public function age()
    {
        return Carbon::instance(new DateTime($this->birthdate))->age;
    }

    /**
     * @param User $user
     * @return bool Whether the user is currently in the specified committee.
     */
    public function isInCommittee(Committee $committee)
    {
        return in_array($this->id, $committee->users->pluck('id')->toArray());
    }

    public function isInCommitteeBySlug($slug)
    {
        $committee = Committee::where('slug', $slug)->first();
        return $committee && $this->isInCommittee($committee);
    }

    /**
     * @return bool Whether the user is an active member of the association.
     */
    public function isActiveMember()
    {
        return count(CommitteeMembership::withTrashed()
                ->where('user_id', $this->id)
                ->where('created_at', '<', date('Y-m-d H:i:s'))
                ->where(function ($q) {
                    $q->whereNull('deleted_at')
                        ->orWhere('deleted_at', '>', date('Y-m-d H:i:s'));
                })->get()
            ) > 0;
    }

    /**
     * @return mixed Any Achievements the user aquired
     */
    public function achieved()
    {
        $achievements = $this->achievements;
        $r = array();
        foreach ($achievements as $achievement) {
            $r[] = $achievement;
        }
        return $r;
    }

    public function withdrawals()
    {
        $withdrawals = [];
        foreach (Withdrawal::orderBy('date', 'desc')->get() as $withdrawal) {
            if ($withdrawal->orderlinesForUser($this)->count() > 0) {
                $withdrawals[] = $withdrawal;
            }
        }
        return $withdrawals;
    }

    public function mollieTransactions()
    {
        return $this->hasMany('Proto\Models\MollieTransaction');
    }

    public function achievements()
    {
        return $this->belongsToMany('Proto\Models\Achievement', 'achievements_users')->withPivot(array('id'))->withTimestamps()->orderBy('pivot_created_at', 'desc');
    }

    public function websiteUrl()
    {
        if (preg_match("/(?:http|https):\/\/(?:.*)/i", $this->website) === 1) {
            return $this->website;
        } else {
            return "http://" . $this->website;
        }
    }

    public function websiteDisplay()
    {
        if (preg_match("/(?:http|https):\/\/(.*)/i", $this->website, $matches) === 1) {
            return $matches[1];
        } else {
            return $this->website;
        }
    }

    public function hasDiet()
    {
        return (strlen(str_replace(["\r", "\n", " "], "", $this->diet)) > 0 ? true : false);
    }

    public function renderDiet()
    {
        return nl2br($this->diet);
    }

    public function getDisplayEmail()
    {
        return $this->member ? sprintf('%s@%s', $this->member->proto_username, config('proto.emaildomain')) : $this->email;
    }

    public function isElegibleForKickInCamp()
    {
        return $this->member && date('U') > config('proto.kickinEvent')->start && date('U') < config('proto.kickinEvent')->end
            && $this->member->created_at->format('U') > config('proto.kickinEvent')->start;
    }

    public function hasTFAEnabled()
    {
        return $this->tfa_totp_key !== null;
    }

    public function hasCompletedProfile()
    {
        return $this->birthdate !== null && $this->phone !== null;
    }

    public function clearMemberProfile()
    {
        $this->birthdate = null;
        $this->phone = null;
        $this->save();
    }

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

    public function generateNewToken()
    {
        $token = new Token();
        $token->generate($this);
        return $token;
    }

    public function generateNewPersonalKey()
    {
        $this->personal_key = str_random(64);
        $this->save();
    }

    public function getPersonalKey()
    {
        if ($this->personal_key == null) {
            $this->generateNewPersonalKey();
        }
        return $this->personal_key;
    }

    public function getCalendarAlarm()
    {
        return $this->pref_calendar_alarm;
    }

    public function setCalendarAlarm($hours)
    {
        $hours = floatval($hours);
        $this->pref_calendar_alarm = ($hours > 0 ? $hours : null);
        $this->save();
    }

    public function getCalendarRelevantSetting()
    {
        return $this->pref_calendar_relevant_only;
    }

    public function toggleCalendarRelevantSetting()
    {
        $this->pref_calendar_relevant_only = !$this->pref_calendar_relevant_only;
        $this->save();
    }

}
