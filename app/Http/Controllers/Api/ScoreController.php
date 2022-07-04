<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

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
        //
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
