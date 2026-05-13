<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'login_view']);

Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');

Route::get('/register', [LoginController::class, 'register_view'])->name('register.view');

Route::post('/register', [UserController::class, 'create'])->name('user.create');

Route::get('/home', [HomeController::class, 'home_view']);


// Página que escuta o evento
Route::get('/receive', function () {
    return view('receive');
});


