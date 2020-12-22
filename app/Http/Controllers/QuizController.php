<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function showRoomDashboard(Room $room)
    {
        $jsonFile = glob(base_path().'/quizzes/'.$room->path.'/*.{json}');
        $quizJson = file_get_contents(base_path().'/quizzes/'.$room->path.'/test.json');
        $quizArray = json_decode($quizJson, true);

        return response(view('admin.room.dashboard', ['room' => $room]));
    }

    public function initialise($number)
    {
        $quizJson = file_get_contents(base_path().'/quizzes/example'.$number.'/test.json');
        $quizArray = json_decode($quizJson, true);

        return view('quiz', array('quizArray' => $quizArray));
    }

    public function getResults(Request $request)
    {

        $quizNumber = $request->all()[0];
        $quizAnswers = $request->all()[1];

        $quizJson = file_get_contents(base_path().'/quizzes/example'.$quizNumber.'/test.json');
        $quizArray = json_decode($quizJson, true);

        $resultsArray = [];

        foreach ($quizArray['questions'] as $questions) {
            $resultsArray[] = $questions['answer'];
        }

        $diff = array_diff($resultsArray, $quizAnswers);
        $numIncorrect = count($diff);

        return response($numIncorrect, 200);
    }

}
