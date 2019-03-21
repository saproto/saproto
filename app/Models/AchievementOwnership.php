<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementOwnership extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'achievements_users';
    protected $hidden = ['user_id'];

    /**
     * @return mixed The user owning the achievement.
     */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    /**
     * @return mixed The achievement this association is for.
     */
    public function achievement()
    {
        return $this->belongsTo('Proto\Models\Achievement');
    }

    protected $fillable = ['user_id', 'achievement_id'];

    protected $rules = array(
        'user_id' => 'required|integer',
        'achievement_id' => 'required|integer',
    );
}