<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsUnixTimestamp implements Rule
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
        if ($value) {
            return ((string) (int) $value === $value) 
               && ($value <= strtotime("now"))
               && ($value >= 0);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Timestamp is not a valid timestamp. It must be in the past and a valid Unix Timestamp.';
    }
}
