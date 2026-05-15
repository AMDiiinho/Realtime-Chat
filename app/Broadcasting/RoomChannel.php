<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Room;

class RoomChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, Room $room): array|bool
    {
        return $user->rooms()->where('room_id', $room->id)->exists();
    }
}
