<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotUtwenteEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $domainPart = explode('@', $value)[1] ?? null;

        if ($domainPart === null || $domainPart === '' || $domainPart === '0') {
            return false;
        }

        return ! str_contains(strtolower($domainPart), 'utwente');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute may not be a utwente email-address';
    }
}
