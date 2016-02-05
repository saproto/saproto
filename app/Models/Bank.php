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
 * @property-read \Proto\Models\User $user
 */
class Bank extends Validatable
{
    protected $table = 'bankaccounts';

    protected $rules = array(
        'iban' => 'required|regex:[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}',
        'bic' => 'required|regex:([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)',
        'machtigingid' => 'required|unique:bankaccounts,machtigingid|regex:(PROTO)(X)([0-9]{5})(X)([0-9]{5})',
        'withdrawal_type' => 'required|in:FRST,RCUR'
    );

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
