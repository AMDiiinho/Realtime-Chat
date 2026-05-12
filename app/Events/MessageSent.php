<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(public string $message) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('chat'),
        ];
    }
}