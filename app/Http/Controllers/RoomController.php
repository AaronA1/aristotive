<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Rules\QuizDirExists;
use App\Rules\QuizJsonExists;
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
    private $repo;

    public function __construct(RoomRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

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
            'quizDir' => ['required', 'string', new QuizDirExists, new QuizJsonExists],
        ]);

        $fullPath = base_path().'/quizzes/'.$validated['quizDir'];

        $roomId = Str::random(6);
        $room = $this->repo->create(['id' => $roomId, 'path' => $fullPath]);

        return redirect()->route('session', $room);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return View
     */
    public function show(Room $room)
    {
        return view('room.show', ['room' => $room]);
    }

    public function joinRoom(Request $request)
    {
        $validated = $request->validate([
            'roomId' => ['required', 'string', resolve(RoomExists::class)],
        ]);

        return redirect()->route('room.show', $validated['roomId']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function destroy(Room $room)
    {
        $this->repo->destroy($room->id);
        return redirect(route('dashboard'));
    }
}
