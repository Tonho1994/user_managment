<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::prefix('users')/* ->middleware(['can:cat_users']) */->group(function () {
    Route::get('/all', [UserController::class, 'getUsers'])->name('api.users.get');
});

/* Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

}); */
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('api.logout');
Route::post('/me', [AuthController::class, 'user'])->middleware('auth:api')->name('api.users.me');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('api.users.refresh');