<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Newsitem extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $guarded = ['id'];

    public function featuredImage()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'featured_image_id');
    }

    public function isPublished() {
        if(Carbon::parse($this->published_at)->isPast()) {
            return true;
        }

        return false;
    }
}
