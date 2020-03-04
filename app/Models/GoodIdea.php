<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GoodIdea extends Model
{
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

    public function userVote() {
        $vote = GoodIdeaVote::where('user_id', Auth::id())->where('good_idea_id', $this->id)->first();
        if($vote) return $vote->vote;
        return 0;
    }
}
