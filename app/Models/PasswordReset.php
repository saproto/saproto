<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Password Reset Model.
 *
 * @property string $email
 * @property string $token
 * @property int $valid_to
 * @property-read User|null $user
 *
 * @method static Builder<static>|PasswordReset newModelQuery()
 * @method static Builder<static>|PasswordReset newQuery()
 * @method static Builder<static>|PasswordReset query()
 * @method static Builder<static>|PasswordReset whereEmail($value)
 * @method static Builder<static>|PasswordReset whereToken($value)
 * @method static Builder<static>|PasswordReset whereValidTo($value)
 *
 * @mixin Model
 */
class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * @return HasOne<User, $this> */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
