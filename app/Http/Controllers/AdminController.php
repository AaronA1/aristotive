<?php

namespace App\Http\Controllers;

use App\Events\NewQuestion;
use App\Models\Question;
use App\Models\Room;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return Renderable
     */
    public function dashboard()
    {
        $rooms = Room::all();
        return view('admin.dashboard', ['rooms' => $rooms]);
    }

    /**
     * Show the room dashboard.
     *
     * @param Room $room
     * @return Renderable
     */
    public function roomDashboard(Room $room)
    {
        Log::info(print_r($room, true));
        return view('admin.session', ['room' => $room]);
    }

    public static function nextQuestion()
    {
        $question = Question::create(['roomId' => '123', 'questionType' => 'multi', 'question' => 'What\'s my name']);
//        NewQuestion::dispatch($question);
        event(new NewQuestion($question));
    }
}
