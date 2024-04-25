<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Create a game
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|string|unique:games'
        ]);

        $game = Game::create($request->all());

        return response()->json($game, 201);
    }

    // Get all Games
    public function index()
    {
        $games = Game::all();
        return response()->json($games);
    }

    // Get one Game
    public function show($id)
    {
        $game = Game::find($id);
        return response()->json($game);
    }

    // Update name game
    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());
        return response()->json($game);
    }

    // Delete Game
    public function destroy($id)
    {
        Game::destroy($id);
        return response()->json(['message' => 'Game deleted']);
    }
}
