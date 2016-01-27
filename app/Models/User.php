<?php

namespace Proto\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
 * @property-read \Proto\Member $member
 * @property-read \Proto\Bank $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Address[] $address
 * @property-read \Proto\Utwente $utwente
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Study[] $study
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function member() {
        return $this->hasOne('Proto\Member');
    }

    public function bank() {
        return $this->hasOne('Proto\Bank');
    }

    public function address() {
        return $this->hasMany('Proto\Address');
    }

    public function utwente() {
        return $this->hasOne('Proto\Utwente');
    }

    public function study() {
        return $this->hasMany('Proto\Study');
    }
}
