<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnglishCharacters implements Rule
{
    public function passes($attribute, $value)
    {
        // Use a regular expression to validate English alphabet characters
        return preg_match('/^[.a-zA-Z&\s\?\-\(\)\,\'\"\~\=\|\/\>\+<\`\*\#\^\%\.\:\@ 0-9]+$/u', $value);
        // return preg_match('/^[?-&() a-zA-Z&\s]+$/u', $value);
    }

    public function message()
    {
        return 'The :attribute field must contain English alphabet characters only.';
    }
}