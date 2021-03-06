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
        $questionsJson = file_get_contents($filename);
        // Pass json directly into Vue component instead of decoding and re-encoding

        return view('admin.session', ['room' => $room, 'questions' => $questionsJson]);
    }
}
