<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;

Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
Route::get('/register', [LoginController::class, 'register_index']);
Route::post('/register', [UserController::class, 'create'])->name('user.create');

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'home_view']);
    
    //rooms
    Route::post('/rooms', [RoomController::class, 'store'])->name('room.store');
    Route::get('/rooms{room}', [RoomController::class, 'index'])->name('room.index');
    Route::post('/rooms/join', [RoomController::class, 'join'])->name('room.join');
    Route::delete('/rooms/{id}', [RoomController::class, 'delete'])->name('room.delete');

    //messages
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    

    Route::get('/test-chat', function () { return view('test-chat'); });
});




