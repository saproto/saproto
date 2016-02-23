<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Proto\Models\Utwente
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $organisational_unit
 * @property string $mail
 * @property string $room_number
 * @property string $phone_number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Proto\Models\User $user
 */
class Utwente extends Model
{
    protected $table = 'utwentes';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
