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

    public function user() {
        return $this->belongsTo('Proto\Models\User', 'user_id');
    }
}