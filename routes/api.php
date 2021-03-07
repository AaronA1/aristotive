<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/quiz/question', 'QuizController@postQuestion');
Route::post('/quiz/response', 'QuizController@postResponse');
Route::get('/quiz/question/{room}', 'QuizController@getQuestion');
Route::get('/quiz/response/{room}', 'QuizController@getResponses');
Route::delete('/quiz/{room}', 'QuizController@endQuiz');
