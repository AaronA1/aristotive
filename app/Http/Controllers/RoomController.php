<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Rules\QuizDirExists;
use App\Rules\RoomExists;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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

        return redirect()->route('session', $room);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return Response|Redirector
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
     * @param Room $room
     * @return Application|Factory|View
     */
    public function destroy(Room $room)
    {
        Log::info('Reach here');
        Room::destroy($room->id);
        return redirect(route('dashboard'));
    }
}