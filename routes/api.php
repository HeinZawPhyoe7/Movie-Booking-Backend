<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieDetailController;
use App\Http\Controllers\SeatController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');

    //Movies
    Route::post('/create/movies', [MovieController::class, 'store'])->name('create-movies');
    Route::get('/getAll/movies', [MovieController::class, 'getAll'])->name('getAll-movies');
    Route::post('/update/movies', [MovieController::class, 'updateMovie'])->name('update-movies');
    Route::post('/delete/movies', [MovieController::class, 'deleteMovie'])->name('delete-movies');
    Route::post('/search/movies', [MovieController::class, 'searchMovies'])->name('search-movie');

    //Movie Details
    Route::post('/create/movie/details', [MovieDetailController::class, 'store'])->name('create-movie-details');
    Route::get('/show/movie/details/{id}', [MovieDetailController::class, 'show'])->name('show-movie-detail');

    //Seat
    Route::get('/getAll/seats', [SeatController::class, 'getAll'])->name('getAll-seats');
});
