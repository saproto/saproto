<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyEntry extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'studies_users';

    /**
     * @return mixed The user this association is for.
     */
    public function user() {
        return $this->belongsTo('Proto\Models\User');
    }

    /**
     * @return mixed The committee this association is for.
     */
    public function study() {
        return $this->belongsTo('Proto\Models\Study');
    }

    protected $guarded = ['id'];
}