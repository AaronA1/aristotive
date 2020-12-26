<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class QuizDirExists implements Rule
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
        $fullPath = base_path().'/quizzes/'.$value;
        return file_exists($fullPath) && is_dir($fullPath);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This is not a valid directory';
    }
}
