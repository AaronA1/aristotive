<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;

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
    public function dashboard(): Renderable
    {
        $rooms = Room::all();
        return view('admin.dashboard', ['rooms' => $rooms]);
    }

    /**
     * Show the room dashboard.
     *
     * @param Room $room
     * @return Renderable
     * @throws Exception
     */
    public function roomDashboard(Room $room): Renderable
    {
        $files = glob($room->path.'/*.json');
        $images = glob($room->path.'/*.{jpg,png}', GLOB_BRACE);

        foreach ($images as $image) {
            copy($image, public_path().'/'.basename($image));
        }

        $questionsJson = file_get_contents($files[0]);
        // Pass json directly into Vue component instead of decoding and re-encoding

        return view('admin.session', ['room' => $room, 'questions' => $questionsJson]);
    }
}
