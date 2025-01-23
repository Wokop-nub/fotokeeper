<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AlbumController;

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

Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');

// Маршрут для обновления фотографии
Route::put('/photos/{id}', [PhotoController::class, 'update'])->name('photos.update');


// Маршруты для альбомов
Route::get('/album', [AlbumController::class, 'index'])->name('album.index');
Route::post('/album', [AlbumController::class, 'store'])->name('album.store');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');
Route::put('/album/{album}', [AlbumController::class, 'update'])->name('album.update');
Route::delete('/album/{album}', [AlbumController::class, 'destroy'])->name('album.destroy');
