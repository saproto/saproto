<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

/**
 * Validatable Model.
 *
 * @method static Builder<static>|Validatable newModelQuery()
 * @method static Builder<static>|Validatable newQuery()
 * @method static Builder<static>|Validatable query()
 *
 * @mixin \Eloquent
 */
class Validatable extends Model
{
    /** @var array|string[] */
    protected array $rules = [];

    protected MessageBag $errors;

    /**
     * @param  array<string, mixed>  $data
     */
    public function validate(array $data): bool
    {
        $v = Validator::make($data, $this->rules);
        if ($v->fails()) {
            $this->errors = $v->errors();

            return false;
        }

        return true;
    }

    public function errors(): MessageBag
    {
        return $this->errors;
    }
}
