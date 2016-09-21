<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Pastry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pastries';

    /**
     * @return mixed The user owning the achievement.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User');
    }

    /**
     * @return mixed The achievement this association is for.
     */

    protected $fillable = ['user_id_a', 'user_id_b', 'person_b'];

    protected $rules = array(
        'user_id_a' => 'required|integer',
        'user_id_b' => 'integer',
        'person_b' => 'string',
        'pastry' => 'required|integer'
    );

    public function user_a()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id_a');
    }

    public function user_b()
    {
        if ($this->user_id_b != null) {
            return User::find($this->user_id_b);
        } else {
            $user = new \stdClass();
            $user->id = "";
            $user->name = $this->person_b;
            return $user;
        }
    }

    public function type()
    {
        switch ($this->pastry) {
            case 0:
                return "Cookies";
                break;
            case 1:
                return "Cake";
                break;
            case 2:
                return "Pie";
                break;
            default:
                return "Unknown";
                break;
        }
    }
}