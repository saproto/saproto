<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Joboffer extends Model
{
    protected $table = 'joboffers';

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('Proto\Models\Company', 'company_id');
    }
}
