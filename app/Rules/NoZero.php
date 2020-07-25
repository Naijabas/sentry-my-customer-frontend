<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpParser\Node\Expr\Cast\String_;

class NoZero implements Rule
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
        $arr = str_split(strval($value));

        // return $arr[3] !== "0";
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please do not start with a zero for the phone number';
    }
}
