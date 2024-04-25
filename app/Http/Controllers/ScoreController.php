<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // Add score
    public function store(Request $request)
    {
        $this->validate($request, [
            'userid' => 'required|exists:users,id',
            'gameid' => 'required|exists:games,id',
            'score' => 'required|integer'
        ]);

        $score = Score::create($request->all());

        return response()->json($score, 201);
    }

    // Get scores
    public function index()
    {
        $scores = Score::with(['user', 'game'])->get();
        return response()->json($scores);
    }

    // Get specific score
    public function show($id)
    {
        $score = Score::with(['user', 'game'])->findOrFail($id);
        return response()->json($score);
    }

    // Update score
    public function update(Request $request, $id)
    {
        $score = Score::findOrFail($id);
        $score->update($request->all());
        return response()->json($score);
    }

    // Delete score
    public function destroy($id)
    {
        Score::destroy($id);
        return response()->json(['message' => 'Score deleted']);
    }
}
