<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievement';

    protected $fillable = ['name', 'desc', 'fa_icon', 'tier'];

    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'achievements_users');
    }

    public function achievementOwnership()
    {
        return $this->hasMany('Proto\Models\AchievementOwnership');
    }

    public function currentOwners($ismember = true)
    {
        $users = array();
        foreach ($this->users as $user) {
            if ((!$ismember || $user->member)) {
                $users[] = $user;
            }
        }
        return $users;
    }
}