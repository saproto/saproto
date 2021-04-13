<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use User;

class QrAuthRequest extends Model
{
    protected $table = 'qrauth_requests';

    protected $guarded = ['id'];

    /**
     * Returns true is QrAuthRequest has been approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        if ($this->approved_at) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the user is request has been approved.
     *
     * @return mixed
     */
    public function authUser()
    {
        if ($this->approved_at) {
            $returnUser = User::findOrFail($this->user_id);
            $this->delete();

            return $returnUser;
        }

        return false;
    }
}
