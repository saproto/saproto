<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodIdeaCategory extends Model
{
    protected $table = 'good_idea_categories';

    protected $guarded = ['id'];

    /** @return HasMany */
    public function ideas(): HasMany
    {
        return $this->hasMany('Proto\Models\GoodIdea', 'idea_category_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo('Proto\Models\User', 'reviewer_id');
    }
}
