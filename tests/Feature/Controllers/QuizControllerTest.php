<?php

namespace Tests\Feature;

use App\Http\Controllers\QuizController;
use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class QuizControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $room;

    protected function setUp(): void
    {
        parent::setUp();
        $this->room = Room::factory()->createOne();
    }

    public function testPostQuestion()
    {
        // Build question request
        $request = [
            'roomId' => 'testRoomId',
            'question' => [
                'type' => 'multi-choice',
                'question' => 'What is 2x2']
            ];
        // Build question Obj
        $questionObj = [
            'room_id' => 'testRoomId',
            'type' => 'multi-choice',
            'question' => 'What is 2x2',
            'options' => null,
            'image' => null
            ];

        // Instantiate mock interfaces and controller
        $questionRepo = Mockery::mock('App\Repositories\Question\QuestionRepositoryInterface');
        $questionRepo->shouldReceive('create')->with($questionObj)->andReturn(true);

        $responseRepo = Mockery::mock('App\Repositories\Response\ResponseRepositoryInterface');

        $controller = new QuizController($questionRepo, $responseRepo);
        $this->app->instance('App\Http\Controllers\QuizController', $controller);

        // Post request and assert response ok
        $response = $this->post('/api/quiz/question', $request);
        $response->assertOk();
    }

    public function testPostResponse()
    {
        $request = [
            'questionId' => 1,
            'answer' => 'testAnswer'
        ];

        $responseObj = [
            'question_id' => 1,
            'answer' => json_encode('testAnswer')
        ];

        // Instantiate mock interfaces and controller
        $questionRepo = Mockery::mock('App\Repositories\Question\QuestionRepositoryInterface');

        $responseRepo = Mockery::mock('App\Repositories\Response\ResponseRepositoryInterface');
        $responseRepo->shouldReceive('create')->with($responseObj)->andReturn(true);

        $controller = new QuizController($questionRepo, $responseRepo);
        $this->app->instance('App\Http\Controllers\QuizController', $controller);

        // Post request and assert response ok
        $response = $this->post('/api/quiz/response', $request);
        $response->assertOk();
    }

    public function testGetQuestionPass()
    {
        $questionObj = [
            'room_id' => 'testRoomId',
            'type' => 'multi-choice',
            'question' => 'What is 2x2',
        ];

        $questionRepo = Mockery::mock('App\Repositories\Question\QuestionRepositoryInterface');
        $questionRepo->shouldReceive('getLatestQuestion')->with($this->room->id)->andReturn($questionObj);

        $responseRepo = Mockery::mock('App\Repositories\Response\ResponseRepositoryInterface');

        $controller = new QuizController($questionRepo, $responseRepo);
        $this->app->instance('App\Http\Controllers\QuizController', $controller);

        // Send get request and assert response ok
        $response = $this->get('/api/quiz/question/'.$this->room->id);
        $response->assertOk();
    }

    public function testGetQuestionFail()
    {
        $questionRepo = Mockery::mock('App\Repositories\Question\QuestionRepositoryInterface');
        $questionRepo->shouldReceive('getLatestQuestion')->with($this->room->id)->andReturn(null);

        $responseRepo = Mockery::mock('App\Repositories\Response\ResponseRepositoryInterface');

        $controller = new QuizController($questionRepo, $responseRepo);
        $this->app->instance('App\Http\Controllers\QuizController', $controller);

        // Post request and assert response ok
        $response = $this->get('/api/quiz/question/'.$this->room->id);
        $response->assertStatus(204);
    }

}
