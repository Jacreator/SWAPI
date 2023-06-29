<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CharactersController;

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



Route::prefix('v1')->group( function () {
    Route::controller(CharactersController::class)->group(function () {
        Route::get('/characters', 'index');
        Route::get('/characters/raw', 'rawData');
        Route::get('/characters/clean', 'cleanData');
    });

    Route::controller(MoviesController::class)->group(function () {
        Route::get('/movies', 'index');
        Route::get('/movies/raw', 'rawData');
        Route::get('/movies/clean', 'cleanData');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/comments', 'store');
        Route::get('/comments', 'index');
    });
});