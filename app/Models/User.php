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
     * @return mixed The associated primary addresses, if any.
     */
    public function primary_address()
    {
        return $this->address()->where('is_primary', true)->get()->first();
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
        return $this->belongsToMany('Proto\Models\Committee', 'committees_users')->whereNull('committees_users.deleted_at')->withPivot(array('role', 'edition', 'id'))->withTimestamps()->orderBy('pivot_created_at', 'asc');
    }

    /**
     * @return mixed Any quotes the user posted
     */
    public function quotes()
    {
        return $this->hasMany('Proto\Models\Quote');
    }

    /**
     * @return mixed Any cards linked to this account
     */
    public function rfid()
    {
        return $this->hasMany('Proto\Models\RfidCard');
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
        return count(CommitteeMembership::whereNull('committees_users.deleted_at')->where('user_id', $this->id)->where('committee_id', $committee->id)->get()) > 0;
    }
}
