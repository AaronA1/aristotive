<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Room;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        ])->latest()->first();

        // Decode options back into array
        $activeQ->options = json_decode($activeQ['options']);

        return response($activeQ);
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
//            ['active', true]
        ])->first();

        $responses = $activeQ->responses()->get();

        return response($responses);
    }

    /**
     * Post a new active question for the given quiz via API
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function postQuestion(Request $request)
    {
        $room = Room::find($request['roomId']);

        $room->current_question = $request['questionIndex'];
        $room->save();

        $options = $request['question']['options'] ?? null;
        if ($options) {
            $options = json_encode($request['question']['options']);
        }

        $question = Question::create([
            'room_id' => $request['roomId'],
            'type' => $request['question']['type'],
            'question' => $request['question']['question'],
            'options' => $options ?? null,
            'image' => $request['question']['image'] ?? null
        ]);

        return response('Success');
    }

    /**
     * Post a response for the given question via API
     *
     * @param Request $request
     * @return ResponseFactory
     */
    public function postResponse(Request $request)
    {
        $response = Response::create([
            'question_id' => $request['questionId'],
            'response' => $request['answer']
        ]);
        return response('Success');
    }

}
