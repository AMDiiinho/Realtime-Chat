<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        broadcast(new MessageSent($data['message']));

        return response()->json([
            'status' => 'Mensagem enviada!',
            'message' => $data['message'],
        ]);
    }
}