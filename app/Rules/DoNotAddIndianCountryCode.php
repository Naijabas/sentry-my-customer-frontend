<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DoNotAddIndianCountryCode implements Rule
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
        $arr = str_split(strval($value), 2);

        return $arr[0] !== $arr[1];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please choose your country from the dropdown and dont include it in your number';
    }
}
