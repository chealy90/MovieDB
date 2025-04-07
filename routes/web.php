<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', function () {
    $movies = Movie::latest()->take(50)->get(); // Adjust as needed
    return view('movies.index', compact('movies'));
});
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
