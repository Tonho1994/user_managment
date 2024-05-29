<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Users actions Routes
Route::prefix('users')->middleware(['can:cat_users'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    //Route::get('/all', [UserController::class, 'getUsers'])->name('users.get');
});
//CV file
Route::get('/cv', function () {
    $headers = [
        'Content-Type' => 'application/pdf',
    ];
    $file_path = public_path('storage/CV_AMZ.pdf');
    return response()->download($file_path, 'cv_amz.pdf', $headers);
})->name('cv');
