<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LithuanianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(\+3706|\+370[5-9])\d{7}$/', $value)) {
            $fail('Please enter a valid Lithuanian phone number. Has to start with +3706 and contain 11 numbers total');
        }
    }
}
