<?php

namespace Proto\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
class User extends Validatable implements AuthenticatableContract,
    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $guarded = ['password', 'remember_token'];

    /**
     * The rules for validation.
     *
     * @var array
     */
    protected $rules = array(
        'email' => 'required|email',
        'phone' => 'regex:(\+[0-9]{1,16})'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return string The full name of the user.
     */
    public function getNameAttribute()
    {
        return $this->name_first . " " . $this->name_last;
    }

    /**
     * @return null|Address The primary address of the user, if any.
     */
    public function getPrimaryAddress()
    {
        foreach ($this->address as $address) {
            if ($address->is_primary) {
                return $address;
            }
        }
        return null;
    }

    /**
     * @return mixed The associated membership details, if any.
     */
    public function member()
    {
        return $this->hasOne('Proto\Models\Member');
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
     * @return mixed The associated addresses, if any.
     */
    public function address()
    {
        return $this->hasMany('Proto\Models\Address');
    }

    /**
     * @return mixed All associated studies, if any.
     */
    public function studies()
    {
        return $this->belongsToMany('Proto\Models\Study', 'studies_users')->withPivot(array('start', 'end', 'id'))->withTimestamps();
    }

    public function committees()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_users')->withPivot(array('start', 'end', 'role', 'edition', 'id'))->withTimestamps()->orderBy('pivot_start', 'asc');
    }

    public function committeesFilter($filter = null)
    {
        $d = $this->committees;
        $r = array();
        switch ($filter) {
            case null:
                // No filter, so no operation.
                break;
            case 'past':
                // Committees the user has been a member of in the past, but not anymore.
                foreach ($d as $k => $c) {
                    if ($c->pivot->end != null && $c->pivot->end < date('U')) {
                        $r[] = $d[$k];
                    }
                }
                break;
            case 'current':
                // Committees the user is currently a member of.
                foreach ($d as $k => $c) {
                    if ($c->pivot->start < date('U') && ($c->pivot->end == null || $c->pivot->end > date('U'))) {
                        $r[] = $d[$k];
                    }
                }
                break;
            case 'future':
                // Committees the user is going to be a member of.
                foreach ($d as $k => $c) {
                    if (($c->pivot->start < date('U') && ($c->pivot->end == null || $c->pivot->end > date('U')))) {
                        $r[] = $d[$k];
                    }
                }
                break;
            default:
                throw new \InvalidArgumentException("Invalid filter. Possible values are null (default), 'past', 'current' and 'future'");
                break;
        }
        return $r;
    }

    /**
     * @return mixed Any quotes the user posted
     */
    public function quotes()
    {
        return $this->hasMany('Proto\Models\Quote');
    }

    /**
     * @return mixed Any Achievements the user aquired
     */
    public function achieved()
    {
        $achievements = $this->achievements;
        $r = array();
        foreach ($achievements as $key => $achievement) {
            $r[] = $achievement;
        }
        return $r;
    }

    public function achievements()
    {
        return $this->belongsToMany('Proto\Models\Achievement', 'achievements_users')->withPivot(array('id', 'created_at'))->withTimestamps()->orderBy('pivot_created_at', 'desc');
    }

    /** @param User $user
     * @return bool Whether the user is currently in the specified committee.
     */
    public function isInCommittee(Committee $committee)
    {
        $p = CommitteeMembership::where('user_id', $this->id)->where('committee_id', $committee->id)->where('start', '<=', date('U'))->get();
        foreach ($p as $participation) {
            if (!$participation->end || $participation->end > date('U')) {
                return true;
            }
        }
        return false;
    }
}