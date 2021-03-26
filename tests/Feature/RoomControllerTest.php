<?php

namespace Tests\Feature;

use App\Http\Controllers\QuizController;
use App\Models\Question;
use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $room;

    protected function setUp(): void
    {
        parent::setUp();
        $this->room = Room::factory()->createOne();
    }

    public function testStore()
    {
        $data = ['quizDir' => 'example'];
        $roomObj = ['id' => $this->room->id, 'path' => 'testPath'];

        // Instantiate mock interfaces and controller
        $roomRepo = Mockery::mock('App\Repositories\Room\RoomRepositoryInterface');
        $roomRepo->shouldReceive('create')->with($roomObj)->andReturn(true);

        $response = $this->post('/room', $data);
        $response->assertRedirect();
    }

    public function testEndRoom()
    {
        $this->assertDatabaseCount('rooms', 1);

        $response = $this->delete('/room/'.$this->room->id);

        $this->assertDatabaseCount('rooms', 0);
        $response->assertRedirect();
    }

    public function testJoinRoomPass()
    {
        $response = $this->get('/room/'.$this->room->id);

        $response->assertOk();
    }

    public function testJoinRoomFail()
    {
        $response = $this->get('/room/roomId');

        $response->assertNotFound();
    }
}
