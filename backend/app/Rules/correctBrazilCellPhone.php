<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class correctBrazilCellPhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace("/[^0-9]/", "", $value);

        $regex = '/^\d{2}\d{9}$/';

        if(!preg_match($regex, $value)){
            $fail('Número de celular inválido');
        }
    }
}
