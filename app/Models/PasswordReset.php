<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $fillable = ['email', 'token', 'valid_to'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('Proto\Models\User', 'email', 'email');
    }
}
