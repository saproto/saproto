<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'pages_studies';

    public function page() {
        return $this->belongsTo('Proto\Models\Page');
    }

    public function study() {
        return $this->belongsTo('Proto\Models\Study');
    }
}
