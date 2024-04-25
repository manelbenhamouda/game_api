<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Create a room
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|integer|max:6|unique:rooms',
            'type' => 'required|boolean',
            'password' => 'required_if:type,1|string'
        ]);

        $room = Room::create($request->all());

        return response()->json($room, 201);
    }

    // Get all rooms
    public function index()
    {
        $rooms = Room::with(['user', 'game']).get();
        return response()->json($rooms);
    }

    // Get one room
    public function show($id)
    {
        $room = Room::with(['user', 'game'])->findOrFail($id);
        return response()->json($room);
    }

    // Update room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return response()->json($room);
    }

    // Delete room
    public function destroy($id)
    {
        Room::destroy($id);
        return response()->json(['message' => 'Room deleted']);
    }
}
