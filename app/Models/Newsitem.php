<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Newsitem extends Model
{
    use SoftDeletes;

    protected $table = 'newsitems';

    protected $guarded = ['id'];

    public function featuredImage()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'featured_image_id');
    }

    public function isPublished()
    {
        if(Carbon::parse($this->published_at)->isPast()) {
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id');
    }

    public function url() {
        return route('news::show', ['id' => $this->id]);
    }
}
