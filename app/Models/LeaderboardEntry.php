<?php


namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardEntry extends Model
{
    protected $table = 'leaderboards_entries';

    protected $guarded = ['id'];

    public function leaderboard() {
        return $this->belongsTo('Proto\Models\Leaderboard', 'leaderboard_id');
    }

    public function member() {
        return $this->hasOne('Proto\Models\Member', 'member_id');
    }
}