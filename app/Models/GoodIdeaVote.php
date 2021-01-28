<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodIdeaVote extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'good_idea_id'];

    public function goodIdea() {
        return $this->hasOne('Proto\Models\GoodIdea');
    }
}
