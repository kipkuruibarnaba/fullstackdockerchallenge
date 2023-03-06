<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Route::get('/', function () {
//     return response()->json([
//         'message' => 'all systems are a go',
//         'users' => \App\Models\User::all(),
//     ]);
// });

Route::get('/', function () {
    return "Backend is running.........";
});

Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::post('/users', [UserController::class, 'addUser']);
Route::put('users/{id}',[UserController::class,'update']);
Route::delete('users/{id}',[UserController::class,'destroy']);
Route::delete('users',[UserController::class,'destroyAll']);
Route::get('search',[UserController::class,'search']);
Route::get('getaddress',[UserController::class,'getAddress']);
Route::get('users/getWeatherInfo/{id}/{lat}/{lon}',[UserController::class,'getUserWeather']);
Route::get('weather',[UserController::class,'weather']);