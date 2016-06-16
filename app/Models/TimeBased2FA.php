<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class TimeBased2FA extends Model
{
    protected $table = 'google2fa';

    /**
     * @return mixed The associated Google 2 Step Authentication, if any.
     */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
