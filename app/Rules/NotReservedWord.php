<?php

namespace App\Rules;

use App\Word;
use Illuminate\Contracts\Validation\Rule;

class NotReservedWord implements Rule
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
        $reserved = Word::pluck('word')->toArray();
        //dd($reserved);

        return !in_array($value, $reserved);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "This word cannot be used as a username.";
    }
}
