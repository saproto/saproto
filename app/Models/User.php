<?php

namespace Proto\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DateTime;
use Carbon\Carbon;

use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Proto\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $utwente_username
 * @property-read \Proto\Models\Member $member
 * @property-read \Proto\Models\Bank $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Models\Address[] $address
 * @property-read \Proto\Models\Utwente $utwente
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Models\Study[] $study
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Models\Role[] $roles
 */
class User extends Model implements AuthenticatableContract,
    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;
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
    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany('Proto\Models\Role', 'role_user');
    }

    /**
     * @return mixed The associated membership details, if any.
     */
    public function member()
    {
        return $this->hasOne('Proto\Models\Member');
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

    public function backupBank()
    {
        return $this->hasOne('Proto\Models\Bank')->withTrashed();
    }

    /**
     * @return mixed The profile picture of this user.
     */
    public function photo()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    /**
     * @return mixed The associated addresses, if any.
     */
    public function address()
    {
        return $this->hasOne('Proto\Models\Address');
    }

    /**
     * @return mixed All associated studies, if any.
     */
    public function studies()
    {
        return $this->belongsToMany('Proto\Models\Study', 'studies_users')->withPivot(array('id', 'deleted_at'))->withTimestamps();
    }

    public function committees()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_users')->withPivot(array('role', 'edition', 'id', 'created_at', 'deleted_at'))->whereNull('committees_users.deleted_at')->withTimestamps()->orderBy('pivot_created_at', 'asc');
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
        return count(CommitteeMembership::withTrashed()
            ->where('user_id', $this->id)
            ->where('committee_id', $committee->id)
            ->where('created_at', '<', date('Y-m-d H:i:s'))
            ->where(function ($q) {
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>', date('Y-m-d H:i:s'));
            })->get()
        ) > 0;
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
        foreach (Withdrawal::all() as $withdrawal) {
            if ($withdrawal->orderlinesForUser($this)->count() > 0) {
                $withdrawals[] = $withdrawal;
            }
        }
        return $withdrawals;
    }

    public function achievements()
    {
        return $this->belongsToMany('Proto\Models\Achievement', 'achievements_users')->withPivot(array('id'))->withTimestamps()->orderBy('pivot_created_at', 'desc');
    }
}
