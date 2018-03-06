<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitteeMembership extends Model
{
    use SoftDeletes;

    protected $hidden = ['id', 'committee_id', 'user_id'];
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'committees_users';

    /**
     * @return mixed The user this association is for.
     */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /**
     * @return mixed The committee this association is for.
     */
    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    protected $guarded = ['id'];
}