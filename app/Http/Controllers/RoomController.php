<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Game;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Room",
 *     title="Room",
 *     description="Room model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the room",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom",
 *         type="integer",
 *         description="Name of the room",
 *         example=1234
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="boolean",
 *         description="Type of the room",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password of the room",
 *         example="optional"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         description="User associated with the room",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="game",
 *         type="object",
 *         description="Game associated with the room",
 *         ref="#/components/schemas/Game"
 *     )
 * )
 */

class RoomController extends Controller
{
    /**
     * @OA\Post(
     *     path="/rooms",
     *     tags={"Room"},
     *     summary="Create a new room",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Provide room details",
     *         @OA\JsonContent(
     *             required={"nom", "type"},
     *             @OA\Property(property="nom", type="integer", example=1234),
     *             @OA\Property(property="type", type="boolean", example=true),
     *             @OA\Property(property="password", type="string", example="optional")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Room created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|integer|unique:rooms',
            'type' => 'required|boolean',
            'password' => 'required_if:type,1|string'
        ]);

        $room = Room::create($request->all());

        return response()->json($room, 201);
    }

    /**
     * @OA\Get(
     *     path="/rooms",
     *     tags={"Room"},
     *     summary="Get list of all rooms with associated user and game details, and available games",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="rooms", type="array", @OA\Items(ref="#/components/schemas/Room")),
     *             @OA\Property(property="games", type="array", @OA\Items(ref="#/components/schemas/Game"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to fetch data"
     *     )
     * )
     */
    public function index()
    {
        try {
            $rooms = Room::with(['user', 'game'])->get();
            $games = Game::all();
            return response()->json([
                'rooms' => $rooms,
                'games' => $games
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch rooms or games: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/rooms/{id}",
     *     tags={"Room"},
     *     summary="Get a single room with associated user and game",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room found",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function show($id)
    {
        $room = Room::with(['user', 'game'])->findOrFail($id);
        return response()->json($room);
    }

    /**
     * @OA\Put(
     *     path="/rooms/{id}",
     *     tags={"Room"},
     *     summary="Update an existing room",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Room data to update",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room updated",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return response()->json($room);
    }

    /**
     * @OA\Delete(
     *     path="/rooms/{id}",
     *     tags={"Room"},
     *     summary="Delete a room",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Room deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Room::destroy($id);
        return response()->json(['message' => 'Room deleted']);
    }
}
