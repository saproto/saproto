<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $guarded = ['id'];

    public function featuredImage()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'featured_image_id');
    }

    public function files()
    {
        return $this->belongsToMany('Proto\Models\StorageEntry', 'pages_files', 'page_id', 'file_id');
    }

    public function getUrl()
    {
        return route('page::show', $this->slug);
    }
}
