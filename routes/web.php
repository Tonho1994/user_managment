<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//Users actions Routes
Route::prefix('users')->middleware(['auth','can:cat_users'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/all', [UserController::class, 'getUsers'])->name('users.get');
    Route::post('/create', [UserController::class, 'create'])->middleware(['can:create_user'])->name('users.create');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/{user}', [UserController::class, 'update'])->middleware(['can:update_user'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware(['can:delete_user'])->name('users.delete');
});
//CV file
Route::get('/cv', function () {
    $headers = [
        'Content-Type' => 'application/pdf',
    ];
    $file_path = public_path('CV_AMZ.pdf');
    return response()->download($file_path, 'cv_amz.pdf', $headers);
})->name('cv');
