<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayNewVideo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $id;
    public function __construct($id, $channel)
    {
        $this->channel = $channel;
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return [
            new PresenceChannel('channel.' . $this->channel->name)
        ];
    }
}
