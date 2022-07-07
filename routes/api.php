<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(ScoreController::class)->prefix("score")->group(function () {
    Route::get("/hello", function (Request $request) {
        return response()->json([['score' => 392384, 'nickname' => "Foo"]]);
    });
    // Get scores for specific project
    Route::get('/{name}/{count?}', "show");
    Route::post('/{name}/', "store")->middleware('valid.encrypted');
});
