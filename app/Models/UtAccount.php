<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $department
 * @property int $member_id
 * @property string $mail
 * @property string $number
 * @property string $givenname
 * @property string|null $middlename
 * @property string $surname
 * @property int $account_expires_at
 * @property bool $found
 * @property Member $member
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class UtAccount extends Model
{
    protected $table = 'ut_accounts';

    protected $fillable = [
        'user_id',
        'department',
        'mail',
        'number',
        'givenname',
        'surname',
        'found',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
