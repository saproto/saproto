<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Support\MessageBag;
use Validator;


/**
 * Validatable Model
 *
 * @mixin Eloquent
 */
class Validatable extends Eloquent
{
    protected $rules = [];

    protected $errors;

    /** @return bool */
    public function validate($data)
    {
        $v = Validator::make($data, $this->rules);
        if ($v->fails()) {
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    /** @return MessageBag */
    public function errors()
    {
        return $this->errors;
    }
}