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
        $files = glob($room->path.'/*.json');

        // If there is no quiz json, destroy the room and return to admin dashboard
        if(empty($files)) {
            Room::destroy($room->id);
            return redirect('admin');
        }

        $filename = $files[0];
        $quizJson = file_get_contents($filename);
        $questions = json_decode($quizJson, true)['questions'];
        Log::info(print_r($questions, true));

        return view('admin.session', ['room' => $room, 'questions' => $questions]);
    }
}
