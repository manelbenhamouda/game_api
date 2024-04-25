<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Game",
 *     title="Game",
 *     description="Game model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom",
 *         type="string",
 *         description="Name of the game",
 *         example="Chess"
 *     )
 * )
 */
class GameController extends Controller
{
    /**
     * Create a new game.
     *
     * @OA\Post(
     *     path="/games",
     *     tags={"Game"},
     *     summary="Create a new game",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Provide game name",
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Chess"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
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
            'nom' => 'required|string|unique:games'
        ]);

        $game = Game::create($request->all());

        return response()->json($game, 201);
    }

    /**
     * Get all games.
     *
     * @OA\Get(
     *     path="/games",
     *     tags={"Game"},
     *     summary="Get list of all games",
     *     @OA\Response(
     *         response=200,
     *         description="Array of games",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Game")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $games = Game::all();
        return response()->json($games);
    }

    /**
     * Get a single game by ID.
     *
     * @OA\Get(
     *     path="/games/{id}",
     *     tags={"Game"},
     *     summary="Get a single game",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Game ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game found",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
     *     )
     * )
     */
    public function show($id)
    {
        $game = Game::find($id);
        return response()->json($game);
    }

    /**
     * Update an existing game.
     *
     * @OA\Put(
     *     path="/games/{id}",
     *     tags={"Game"},
     *     summary="Update an existing game",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Game ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Game data to update",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game updated",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());
        return response()->json($game);
    }

    /**
     * Delete a game by ID.
     *
     * @OA\Delete(
     *     path="/games/{id}",
     *     tags={"Game"},
     *     summary="Delete a game",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Game ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Game deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Game::destroy($id);
        return response()->json(['message' => 'Game deleted']);
    }
}
