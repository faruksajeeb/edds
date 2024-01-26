<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BanglaCharacters implements Rule
{
    public function passes($attribute, $value)
    {
        // Use a regular expression to validate Bangla characters
        return preg_match('/^[.\/\?\(\)\p{Bengali}\s\&\.\,\'\"\~\=\|\>\+<\`\*\#\^\%\.\-\: ০-৯]+$/u', $value);
    }

    public function message()
    {
        return 'The :attribute field must contain Bangla characters only.';
    }
}

