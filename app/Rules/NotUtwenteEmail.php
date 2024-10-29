<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotUtwenteEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         $domainPart = explode('@', $value)[1] ?? null;

        if ($domainPart === null || $domainPart === '' || $domainPart === '0') {
            $fail('The :attribute may not be a utwente email-address'); // maybe a different error, since this means the email wasnt parsed properly
        }

        if (str_contains(strtolower($domainPart), 'utwente')) {
            $fail('The :attribute may not be a utwente email-address');
        }
    }
}
