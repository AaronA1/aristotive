<?php

namespace App\Http\Controllers;

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
        return view('admin.dashboard');
    }

    /**
     * Show the room dashboard.
     *
     * @param Room $room
     * @return Renderable
     */
    public function roomDashboard(Room $room)
    {
        Log::info(print_r($room->id, true));
        return view('admin.room.dashboard');
    }
}
