<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Room;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'body' => 'required|string',
        ]);

        $room = Room::findOrFail($request->room_id);

        $isMember = $room->myUsers()->where('users.id', auth()->id())->exists();

        if (! $isMember) {
            abort(404, 'Você não pertence à esta sala');
        }


        $message = Message::create([
            'room_id' => $request->room_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->username,
                ],
            ],
        ]);
    }
}