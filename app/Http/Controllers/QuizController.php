<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Room;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class QuizController
{

    /**
     * Fetch current active question for the given quiz via API
     *
     * @param Room $room
     * @return ResponseFactory
     */
    public function getQuestion(Room $room)
    {
        $activeQ = Question::where([
            ['room_id', $room->id],
            ['active', true]
        ])->first();

        return response($activeQ, 200);
    }

    /**
     * Fetch question responses for the given quiz via API
     *
     * @param Room $room
     * @return ResponseFactory
     */
    public function getResponses(Room $room)
    {
        $activeQ = Question::where([
            ['room_id', $room->id],
            ['active', true]
        ])->first();

        $responses = $activeQ->responses()->get();

        return response($responses, 200);
    }

    /**
     * Post a new active question for the given quiz via API
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function postQuestion(Request $request)
    {
        return response('', 200);
    }

    /**
     * Post a response for the given question via API
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function postResponse(Request $request)
    {
        return response('', 200);
    }

}
