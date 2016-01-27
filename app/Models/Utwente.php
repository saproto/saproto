<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Proto\Utwente
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $organisational_unit
 * @property string $mail
 * @property string $room_number
 * @property string $phone_number
 * @property-read \Proto\User $user
 */
class Utwente extends Model
{
    protected $table = 'utwentes';

    public function user()
    {
        return $this->belongsTo('Proto\User');
    }
}
