<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;

use Illuminate\Support\Facades\Route;
use App\Models\Movie;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');


//session and register
//Route::view('/login'  , '/loginAndRegister.login');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('login', [LoginController::class, 'login'])->name('login.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegistrationController::class, 'create'])->name('register.index');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
