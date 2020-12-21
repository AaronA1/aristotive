<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

/** Auth routes */
//Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/** Room routes */
Route::get('/quiz/{number?}', 'QuizController@initialise');
Route::post('/quiz/results', 'QuizController@getResults')->name('join-room');
Route::resource('room', RoomController::class);

/** Admin routes */
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
