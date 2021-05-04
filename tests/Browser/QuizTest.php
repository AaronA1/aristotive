<?php

namespace Tests\Browser;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class QuizTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Tests that an admin can start a room
     *
     * @return void
     * @throws Throwable
     */
    public function testCreateRoom()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin')
                ->type('quizDir', 'example')
                ->press('Create Room')
                ->assertSee('Begin Quiz');
            $this->assertDatabaseCount('rooms', 1);
        });
    }

    /**
     * Tests that the admin can begin a quiz
     *
     * @throws Throwable
     */
    public function testAnswerQuestion()
    {
        $this->seed();

        $this->browse(function ($first, $second) {

            $first->loginAs(User::find(1))
                ->visit('/admin')
                ->type('quizDir', 'example')
                ->press('Create Room')
                ->assertSee('Begin Quiz')
                ->press('Begin Quiz');

            $room = Room::first();

            $second->visit('/room/'.$room->id)
                ->assertSee('Waiting on the next question')
                ->pause(11000)
                ->type('inputAnswer', 'Test Answer')
                ->press('Submit')
                ->assertSee('Waiting on the next question');

            $this->assertDatabaseHas('responses', ['answer' => 'Test Answer']);
        });
    }

    /**
     * Tests that the admin can change questions and view responses
     *
     * @throws Throwable
     */
    public function testViewResponses()
    {
        $this->seed();

        $this->browse(function ($first, $second, $third) {

            $first->loginAs(User::find(1))
                ->visit('/admin')
                ->type('quizDir', 'example')
                ->press('Create Room')
                ->assertSee('Begin Quiz')
                ->press('Begin Quiz');

            $room = Room::first();

            $second->visit('/room/'.$room->id)
                ->assertSee('Waiting on the next question')
                ->pause(11000)
                ->type('inputAnswer', 'Test Answer')
                ->press('Submit')
                ->assertSee('Waiting on the next question');

            $third->visit('/room/'.$room->id)
                ->assertSee('Waiting on the next question')
                ->pause(11000)
                ->type('inputAnswer', 'Another Answer')
                ->press('Submit')
                ->assertSee('Waiting on the next question');

            $first->press('Show Answers')
                ->pause(2000)
                ->assertSee('Test Answer')
                ->assertSee('Another Answer')
                ->press('Next Question')
                ->assertDontSee('Test Answer')
                ->assertDontSee('Another Answer');

        });
    }
}
