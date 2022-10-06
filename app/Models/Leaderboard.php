<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $table = 'leaderboards';

    protected $guarded = ['id'];

    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee', 'committee_id');
    }

    public function entries()
    {
        return $this->hasMany('Proto\Models\LeaderboardEntry');
    }
}
