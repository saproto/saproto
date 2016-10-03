<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeMessage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_welcome';

    /**
     * @return mixed The user owning the achievement.
     */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    protected $fillable = ['user_id', 'message'];

    protected $rules = array(
        'user_id' => 'required|integer',
        'message' => 'required|string',
    );
}