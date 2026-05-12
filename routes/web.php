<?php

use app\Http\Controllers\MessageController;

// Página que escuta o evento
Route::get('/receive', function () {
    return view('receive');
});

Route::post('/messages', [MessageController::class, 'store']);
