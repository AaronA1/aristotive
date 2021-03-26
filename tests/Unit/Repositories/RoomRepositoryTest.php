<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Response;
use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoomRepositoryTest extends TestCase
{

    use DatabaseMigrations;
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = resolve(RoomRepositoryInterface::class);
    }

    public function testBuildRoom()
    {
        $room = [
            'id' => 'testRoomId',
            'path' => 'testPathToDirectory',
        ];

        // Persist using repo
        $this->repo->create($room);

        // Assert model is persisted
        $this->assertDatabaseHas('rooms', [
            'path' => $room['path']
        ]);
    }

    public function testDestroyRoom()
    {
        // Persist Room
        $room = Room::factory()->createOne();

        // Assert model in database
        $this->assertDatabaseHas('rooms', [
            'path' => $room['path']
        ]);

        // Destroy room
        $this->repo->destroy($room->id);

        // Assert model is missing
        $this->assertDatabaseMissing('rooms', [
            'path' => $room['path']
        ]);
    }

    public function testDestroyRoomAndChildren()
    {
        // Persist Room, Questions and Responses
        $room = Room::factory()->createOne();
        $question = Question::factory()->createOne();
        $responses = Response::factory()->count(40)->create();

        // Assert models in database
        $this->assertDatabaseCount('rooms', 1);
        $this->assertDatabaseCount('questions', 1);
        $this->assertDatabaseCount('responses', 40);

        // Destroy room
        $this->repo->destroy($room->id);

        // Assert models deleted and cascaded
        $this->assertDatabaseCount('rooms', 0);
        $this->assertDatabaseCount('questions', 0);
        $this->assertDatabaseCount('responses', 0);

    }
}
