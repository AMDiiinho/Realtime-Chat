<?php

use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'login'])->name('login.view');

Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');


// Página que escuta o evento
Route::get('/receive', function () {
    return view('receive');
});


