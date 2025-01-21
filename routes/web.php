<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;


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

Route::get('/login', function () {
    return view('login');
});
Route::get('/signin', function () {
    return view('signin');
});
Route::get('/index', [PhotoController::class, 'index']);
Route::get('/album', function () {
    return view('album');
});
Route::get('/shared', function () {
    return view('shared');
});

Route::post('/upload', [PhotoController::class, 'store'])->name('photos.store');
