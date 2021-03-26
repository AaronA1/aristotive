<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Session;
use App\Repositories\Question\QuestionRepositoryInterface;
use App\Repositories\Response\ResponseRepositoryInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizController
{
    private $questionRepo;
    private $responseRepo;

    public function __construct(QuestionRepositoryInterface $questionRepo, ResponseRepositoryInterface $responseRepo)
    {
        $this->questionRepo = $questionRepo;
        $this->responseRepo = $responseRepo;
    }

    /**
     * Fetch current active question for the given quiz via API
     *
     * @param Room $room
     * @return ResponseFactory|Response
     */
    public function getQuestion(Room $room)
    {
        $activeQ = $this->questionRepo->getLatestQuestion($room->id);

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
     * @return ResponseFactory|Response
     */
    public function getResponses(Room $room)
    {
        $activeQ = $this->questionRepo->getLatestQuestion($room->id);

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
     * @return ResponseFactory|Response
     */
    public function postQuestion(Request $request)
    {
        $options = $request['question']['options'] ?? null;
        if ($options) {
            $options = json_encode($request['question']['options']);
        }

        $question = $this->questionRepo->create([
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
     * @return ResponseFactory|Response
     */
    public function postResponse(Request $request)
    {
        $response = $this->responseRepo->create([
            'question_id' => $request['questionId'],
            'answer' => json_encode($request['answer'])
        ]);
        return response('Success');
    }

    /**
     * Count the number of current sessions for member count
     * @return Response
     */
    public function countSessions(): Response
    {
        return response(Session::all());
    }

}
