<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodIdeaCategory extends Model
{
    protected $table = 'good_idea_categories';

    protected $guarded = ['id'];

    /** @return HasMany */
    public function goodIdeas(): HasMany
    {
        return $this->hasMany('Proto\Models\GoodIdea');
    }
}
