<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string department
 * @property int user_id
 * @property string mail
 * @property string number
 * @property string givenname
 * @property string|null middlename
 * @property string surname
 * @property User user
 * @property mixed id
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class UtAccount extends Model
{
    use SoftDeletes;

    protected $table = 'ut_accounts';

    protected $fillable = [
        'user_id',
        'department',
        'mail',
        'number',
        'givenname',
        'middlename',
        'surname',
        'account_expires_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
