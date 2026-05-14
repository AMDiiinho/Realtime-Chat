<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');

Route::get('/register', [LoginController::class, 'register_index']);

Route::post('/register', [UserController::class, 'create'])->name('user.create');

Route::get('/home', [HomeController::class, 'home_view']);

Route::post('/home', [RoomController::class, 'create'])->name('room.create');


// Página que escuta o evento
Route::get('/receive', function () {
    return view('receive');
});


