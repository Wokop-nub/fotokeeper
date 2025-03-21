<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
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

Route::get('/', [PageController::class, 'index']);
Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/signin', function () {
    return view('auth/signin');
});
Route::get('logout', [UserController::class, 'logout']);

Route::get('/album', [PageController::class, 'mainAlbum']);
Route::get('/album/{path?}', [PageController::class, 'album'])->where('path', '.*');
Route::get('/upload', [PageController::class, 'upload']);
