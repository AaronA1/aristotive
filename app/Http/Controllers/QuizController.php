<?php

namespace App\Http\Controllers;

class QuizController
{

    public function initialise($number)
    {
        $quizJson = file_get_contents(base_path().'/quizzes/example'.$number.'/test.json');
        $quizArray = json_decode($quizJson, true);

        return view('quiz', array('quizArray' => $quizArray));
    }

}
