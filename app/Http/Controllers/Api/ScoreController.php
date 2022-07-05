<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Highscore;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $decryptedData = $request->get('data');

        $validator = Validator::make($decryptedData, [
            'nickname' => 'required|string|max:100',
            'score' => 'required|integer',
            'source' => 'required|string',
            'project_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                ...$decryptedData
            ], 400);
        }

        Highscore::create($decryptedData);

        return response()->json([
            'status' => 'OK',
            ...$decryptedData
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name, $count = 10)
    {
        return Project::where('name', $name)
            ->with([
                'highscores' => function ($query) use ($count) {
                    $query
                        ->limit($count)
                        ->orderBy("score", "DESC")
                        ->select(["score", "nickname", "project_id"]);
                }
            ])
            ->firstOrFail()
            ->highscores
            ->map(function ($item) {
                return [
                    'score' => $item->score,
                    'nickname' => $item->nickname,
                ];
            });
    }
}
