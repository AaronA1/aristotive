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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return redirect('login');
});
Route::get('/home', 'HomeController@index')->name('home');

/** Auth routes */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/** Admin routes */
Route::get('/admin', 'AdminController@dashboard')->name('dashboard');
Route::get('/admin/{room}', 'AdminController@roomDashboard')->name('session');

/** Room join route */
Route::post('/quiz', 'RoomController@join')->name('joinRoom');

/** Room resource route */
Route::resource('room', 'RoomController')->only(['store', 'show', 'destroy']);


