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
class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

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
     * The rules for validation.
     *
     * @var array
     */
    protected $rules = array(
        'name' => 'required',
        'email' => 'required|email'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function member() {
        return $this->hasOne('Proto\Models\Member');
    }

    public function bank() {
        return $this->hasOne('Proto\Models\Bank');
    }

    public function address() {
        return $this->hasMany('Proto\Models\Address');
    }

    public function utwente() {
        return $this->hasOne('Proto\Models\Utwente');
    }

    public function study() {
        return $this->hasMany('Proto\Models\Study');
    }
}
