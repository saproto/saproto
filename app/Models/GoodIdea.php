<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GoodIdea extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'idea'];
    public function user() {
        return $this->belongsTo('Proto\Models\User');
    }

    public function votes() {
        return $this->hasMany('Proto\Models\GoodIdeaVote');
    }

    public function voteScore() {
        return $this->votes()->sum('vote');
    }

    public function userVote(User $user) {
        $vote = $this->votes()->where('user_id', $user->id)->first();
        if($vote) return $vote->vote;
        return 0;
    }
}
