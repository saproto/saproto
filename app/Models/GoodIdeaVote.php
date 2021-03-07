<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class GoodIdeaVote extends Model
{
    protected $fillable = ['user_id', 'good_idea_id'];

    public function goodIdea() {
        return $this->hasOne('Proto\Models\GoodIdea');
    }
}
