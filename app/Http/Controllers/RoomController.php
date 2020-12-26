<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Rules\QuizDirExists;
use App\Rules\RoomExists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quizDir' => ['required', 'string', new QuizDirExists],
        ]);

        $fullPath = base_path().'/quizzes/'.$validated['quizDir'];

        $roomId = Str::random(6);
        $room = Room::create(['id' => $roomId, 'path' => $fullPath]);
//        Log::info(print_r($room, true));

        return redirect()->route('session', $room);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return response(view('room.show', ['room' => $room]));
    }

    public function joinRoom(Request $request)
    {
        $validated = $request->validate([
            'roomId' => ['required', 'string', new RoomExists],
        ]);

        return redirect()->route('room.show', $validated['roomId']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
