<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Score",
 *     title="Score",
 *     description="Score model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the score",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="userid",
 *         type="integer",
 *         description="ID of the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="gameid",
 *         type="integer",
 *         description="ID of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="score",
 *         type="integer",
 *         description="User's score in the game",
 *         example=500
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         description="User associated with the score",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="game",
 *         type="object",
 *         description="Game associated with the score",
 *         ref="#/components/schemas/Game"
 *     )
 * )
 */
class ScoreController extends Controller
{
    /**
     * @OA\Post(
     *     path="/scores",
     *     tags={"Score"},
     *     summary="Create a new score",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Provide score details",
     *         @OA\JsonContent(
     *             required={"userid", "gameid", "score"},
     *             @OA\Property(property="userid", type="integer", example=1),
     *             @OA\Property(property="gameid", type="integer", example=1),
     *             @OA\Property(property="score", type="integer", example=500),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Score created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
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
            'userid' => 'required|exists:users,id',
            'gameid' => 'required|exists:games,id',
            'score' => 'required|integer'
        ]);

        $score = Score::create($request->all());

        return response()->json($score, 201);
    }

    /**
     * @OA\Get(
     *     path="/scores",
     *     tags={"Score"},
     *     summary="Get list of all scores with associated user and game",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Score")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $scores = Score::with(['user', 'game'])->get();
        return response()->json($scores);
    }

    /**
     * @OA\Get(
     *     path="/scores/{id}",
     *     tags={"Score"},
     *     summary="Get a specific score with associated user and game",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Score ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Score found",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
     *     )
     * )
     */
    public function show($id)
    {
        $score = Score::with(['user', 'game'])->findOrFail($id);
        return response()->json($score);
    }

    /**
     * @OA\Put(
     *     path="/scores/{id}",
     *     tags={"Score"},
     *     summary="Update an existing score",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Score ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Score data to update",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Score updated",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $score = Score::findOrFail($id);
        $score->update($request->all());
        return response()->json($score);
    }

    /**
     * @OA\Delete(
     *     path="/scores/{id}",
     *     tags={"Score"},
     *     summary="Delete a score",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Score ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Score deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Score deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Score::destroy($id);
        return response()->json(['message' => 'Score deleted']);
    }
}
