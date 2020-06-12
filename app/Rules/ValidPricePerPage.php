<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPricePerPage implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value > 1) {
          return false;
        } else if ($value < 0) {
          return false;
        } else {
          return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'De prijs per pagina moet tussen 0 en 1 euro liggen.';
    }
}
