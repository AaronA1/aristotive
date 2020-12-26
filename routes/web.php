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
Route::get('/home', 'HomeController@index')->name('home');

/** Auth routes */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/** Admin routes */
Route::get('/admin', 'AdminController@dashboard')->name('admin');
Route::get('/admin/{room}', 'AdminController@roomDashboard')->name('session');

/** Room routes */
Route::resource('room', 'RoomController')->except(['create', 'edit', 'update']);

/** Quiz Routes */
Route::post('/quiz', 'RoomController@joinRoom')->name('joinRoom');

/** Old Routes */
Route::get('/quiz/{number?}', 'QuizController@initialise');
Route::post('/quiz/results', 'QuizController@getResults')->name('join-room');
