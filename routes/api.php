<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/signin', [UserController::class, 'signin']);

Route::group(['prefix' => '/photo'], function () {
    Route::post('/upload', [PhotoController::class, 'create']);
    Route::delete('/delete', [PhotoController::class, 'destroy']);
});

Route::group(['prefix' => '/album'], function () {
    Route::post('/create', [AlbumController::class, 'create']);
    Route::put('/rename', [AlbumController::class, 'rename']);
    Route::post('/move-to-trash', [AlbumController::class, 'moveToTrash']);
    Route::post('/upload', [AlbumController::class, 'uploadPhoto']);
});
