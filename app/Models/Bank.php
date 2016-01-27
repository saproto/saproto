<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Proto\Bank
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $iban
 * @property string $bic
 * @property string $machtigingid
 * @property string $withdrawal_type
 * @property-read \Proto\User $user
 */
class Bank extends Model
{
    protected $table = 'bankaccounts';

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
