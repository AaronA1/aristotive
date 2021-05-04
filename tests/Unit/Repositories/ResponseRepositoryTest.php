<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Response;
use App\Models\Room;
use App\Repositories\Response\ResponseRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ResponseRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = resolve(ResponseRepositoryInterface::class);
        // Setup a room and question before every test for primary key constraints
        Room::factory()->createOne();
        Question::factory()->createOne();
    }

    public function testPostResponsePass()
    {
        $response = [
            'question_id' => 1,
            'answer' => json_encode('Test Answer'),
        ];

        // Persist using repo
        $this->repo->create($response);

        // Assert model is persisted
        $this->assertDatabaseHas('responses', [
            'answer' => json_decode($response['answer'])
        ]);
    }

    public function testGetAllResponses()
    {
        // Use factory to persist 10 records
        Response::factory()->count(10)->create();

        // Assert all models are persisted
        $this->assertDatabaseCount('responses', 10);

        // Get all and assert they are all retrieved
        $responses = $this->repo->all();
        $this->assertCount(10, $responses);
    }
}
