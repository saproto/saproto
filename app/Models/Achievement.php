<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievement';

    protected $fillable = ['name', 'desc', 'fa_icon', 'tier', 'is_archived'];

    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'achievements_users');
    }

    public function achievementOwnership()
    {
        return $this->hasMany('Proto\Models\AchievementOwnership');
    }

    public function numberOfStars() {
        $map = [
            'COMMON' => 1,
            'UNCOMMON' => 2,
            'RARE' => 3,
            'EPIC' => 4,
            'LEGENDARY' => 5
        ];
        return $map[$this->tier];
    }

    public function currentOwners($ismember = true)
    {
        $users = array();
        foreach ($this->users as $user) {
            if ((!$ismember || $user->is_member)) {
                $users[] = $user;
            }
        }
        return $users;
    }
}