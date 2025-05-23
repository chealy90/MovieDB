<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\PlaylistController;

use Illuminate\Support\Facades\Route;
use App\Models\Movie;


Route::get('/', function () {
    return view('welcome');
});

//search
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');


Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');


//session and register
//Route::view('/login'  , '/loginAndRegister.login');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('login', [LoginController::class, 'login'])->name('login.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegistrationController::class, 'create'])->name('register.index');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');


//profile
Route::get('/profile', [UserController::class, 'private'])->name('profile.private')->middleware('auth');
Route::get('/profile/{user}', [UserController::class, 'public'])->name('profile.public');
Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update'); // update profile
Route::post('/profile/{user}/follow', [UserController::class, 'follow'])->name('profile.follow')->middleware('auth'); // follow user
Route::post('/profile/{user}/unfollow', [UserController::class, 'unfollow'])->name('profile.unfollow')->middleware('auth'); // unfollow user


//review
Route::post('/postReview/{movie}/{user}', [ReviewController::class, 'create'])->name('postReview');



// personas (actors/directors)
Route::get('/person/{id}', [PersonController::class, 'show'])->name('person.show');
Route::get('/movieReviews/{id}', [ReviewController::class, 'findByMovie'])->name('movieReviews');


//user playlist routes
//watchlist
Route::post('/addToWatchlist/{movie}/{user}', [UserController::class, 'addToWatchlist'])->name('watchlist.add');
Route::post('/addFromWatchlist/{movie}/{user}', [UserController::class, 'removeFromWatchlist'])->name('watchlist.remove');
Route::get('/watchlist/{user}', [UserController::class, 'displayWatchlist'])->name('watchlist.display');

//watched list
Route::post('/addToWatchedList/{movie}', [UserController::class, 'setWatched'])->name('watched.add');
Route::post('/removeFromWatchedList/{movie}', [UserController::class, 'setUnwatched'])->name('watched.remove');

//custom playlists
Route::post('/createPlaylist', [PlaylistController::class, 'store'])->name('playlist.create');
Route::post('/addToPlaylist', [PlaylistController::class, 'addToPlaylist'])->name('playlist.addMovie');
Route::delete('/removeFromPlaylist/{playlistID}/{movieID}', [PlaylistController::class, 'removeFromPlaylist'])->name('playlist.removeMovie');

Route::get('/playlist/{playlistID}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::delete('/playlist/delete/{id}', [PlaylistController::class, 'destroy'])->name('playlist.delete');

