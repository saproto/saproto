<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Proto\Models\Member
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $proto_mail
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $since
 * @property string $till
 * @property string $type
 * @property string $fee_cycle
 * @property boolean $primary_member
 * @property-read \Proto\Models\User $user
 */
class Member extends Model
{
    protected $table = 'members';

    protected $rules = array(
    );

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
