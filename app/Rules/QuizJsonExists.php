<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class QuizJsonExists implements Rule
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
        $files = glob($fullPath.'/*.json');
        return !empty($files);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is no .json file in this directory';
    }
}
