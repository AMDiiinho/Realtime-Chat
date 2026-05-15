<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    $isOwner = Room::where('id', $roomId)
        ->where('owner_id', $user->id)
        ->exists();

    $isMember = DB::table('room_user')
        ->where('room_id', $roomId)
        ->where('user_id', $user->id)
        ->exists();

    return $isOwner || $isMember;
});