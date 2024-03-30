<?php

use App\Http\Controllers\API\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\TopicController;
use App\Http\Controllers\API\BoosterController;
use App\Http\Controllers\API\UserBoostController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RankController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('/booster', BoosterController::class);
Route::apiResource('/questions', QuestionController::class);
Route::apiResource('/topics', TopicController::class);

// Itt hozzáadjuk az egyedi útvonalakat az apiResource hívások előtt
Route::put('/userboosts/use', [UserBoostController::class, 'updateUserBoosterStatus']);
Route::post('/userboosts/reset/{userId}', [UserBoostController::class, 'resetBoostersForNewGame']);
Route::get('/userboosts/user/{userId}', [UserBoostController::class, 'boostersByUserId']);

// Most már az apiResource hívás tartalmazhatja az 'update' műveletet is, mivel az egyedi útvonalak már definiálva vannak
Route::apiResource('/userboosts', UserBoostController::class);
Route::apiResource('user-ranks', RankController::class);

Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::get('/topics', [TopicController::class, 'index']);
