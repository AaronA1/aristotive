<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController
{

    /**
     * Fetch current active question for the given quiz via API
     *
     * @param Room $room
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function getQuestion(Room $room)
    {
        $activeQ = Question::where('room_id', $room->id)
            ->latest()
            ->first();

        if(empty($activeQ)) {
            return response('No active question', 204);
        }
        // If there are options, decode back into array
        if (!empty($activeQ->options)) {
            $activeQ->options = json_decode($activeQ['options']);
        }

        return response($activeQ);
    }

    /**
     * Fetch question responses for the given quiz via API
     *
     * @param Room $room
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function getResponses(Room $room)
    {
        $activeQ = Question::where([
            ['room_id', $room->id],
//            ['active', true]
        ])->latest()->first();

        $responses = $activeQ->responses()->get();
        foreach ($responses as $response) {
            $response['answer'] = json_decode($response['answer']);
        }

        return response($responses);
    }

    /**
     * Post a new active question for the given quiz via API
     *
     * @param Request $request
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function postQuestion(Request $request)
    {
//        $room = Room::find($request['roomId']);
//
//        $room->current_question = $request['questionIndex'];
//        $room->save();

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
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function postResponse(Request $request)
    {
        $response = Response::create([
            'question_id' => $request['questionId'],
            'answer' => json_encode($request['answer'])
        ]);
        return response('Success');
    }

    /**
     * Pull down the current room along with questions and responses
     *
     * @param Room $room
     * @return ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function endQuiz(Room $room)
    {
        $room->delete();

        return response("Success");
    }

}
