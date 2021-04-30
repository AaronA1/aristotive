<?php

namespace Tests\Browser;

use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Tests that the reaching the root redirects to login
     *
     * @throws Throwable
     */
    public function testReachLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login');
        });
    }

    /**
     * Tests that admin can login successfully
     *
     * @throws Throwable
     */
    public function testLoginAdmin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'admin')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/admin');
        });
    }

    /**
     * Tests that audience member can join room successfully
     *
     * @throws Throwable
     */
    public function testLoginAudience()
    {
        $room = Room::factory()->create();

        $this->browse(function (Browser $browser) use ($room) {
            $browser->visit('/login')
                ->type('roomId', $room->id)
                ->press('Enter Room')
                ->assertPathIs('/room/'.$room->id);
        });
    }
}
