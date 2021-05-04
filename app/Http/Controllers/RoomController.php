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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    private $repo;

    public function __construct(RoomRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Store a newly created resource (Room) in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
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
     * Display the specified (Room) resource.
     *
     * @param Room $room
     * @return View
     */
    public function show(Room $room): View
    {
        return view('room.show', ['room' => $room]);
    }

    /**
     * Join the room as an audience member with room id in the request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function join(Request $request): RedirectResponse
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
     */
    public function destroy(Room $room)
    {
        $this->repo->destroy($room->id);
        return redirect(route('dashboard'));
    }
}
