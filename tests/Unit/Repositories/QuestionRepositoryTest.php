<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Room;
use App\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = resolve(QuestionRepositoryInterface::class);
        // Setup a room before every test for primary key constraints
        Room::factory()->createOne();
    }

    public function testPostQuestionPass()
    {
        $question = [
            'room_id' => 'testRoomId',
            'type' => 'multi-choice',
            'question' => 'What is 2+2',
            'options' => json_encode(['1', '2', '3', '4']),
            'image' => ''
        ];

        // Persist using repo
        $this->repo->create($question);

        // Assert model is persisted
        $this->assertDatabaseHas('questions', [
            'question' => $question['question']
        ]);
    }

    public function testGetLatestQuestion()
    {
        // Use factory to persist two questions
        $questionOne = Question::factory()->create([
            'question' => 'Test Question One',
            'created_at' => now()->subSecond()]);

        $questionTwo = Question::factory()->create(['question' => 'Test Question Two']);

        // Assert both are persisted
        $this->assertDatabaseCount('questions', 2);

        // Get latest
        $question = $this->repo->getLatestQuestion('testRoomId');

        // Assert is the second (most recent) question
        $this->assertEquals('Test Question Two', $question->question);
    }

}
