<?php

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
    return view('welcome');
});

//Route::group(['middleware' => 'auth'], function () {
//
//});

Route::resource('/schedule', \App\Http\Controllers\ScheduleController::class)
    ->only(['index', 'store']);
Route::delete('/schedule', [\App\Http\Controllers\ScheduleController::class, 'destroy']);

Route::resource('/schedule-interval', \App\Http\Controllers\ScheduleIntervalController::class)
    ->only(['index', 'store']);
