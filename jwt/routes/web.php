<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

Route::post('/login',[LoginController::class,'login']);

Route::get('unauthorized',function () {
    return response()->json([
        'status' => 'error',
        'msg' => 'Unauthorized'
    ], 400);
})->name('api.jwt.unauthorized');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user',[LoginController::class,'user'])->name('api.jwt.user');
});

