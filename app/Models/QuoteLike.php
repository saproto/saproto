<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteLike extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quotes_users';

    /**
     * @return mixed The user owning the achievement.
     */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    /**
     * @return mixed The achievement this association is for.
     */
    public function quote()
    {
        return $this->belongsTo('Proto\Models\Quote');
    }

    protected $fillable = ['user_id', 'quote_id'];

    protected $rules = [
        'user_id'  => 'required|integer',
        'quote_id' => 'required|integer',
    ];
}
