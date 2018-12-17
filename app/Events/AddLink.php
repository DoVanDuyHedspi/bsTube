<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Channel as Cn;

class AddLink implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playlists;
    public $channel;
    public function __construct(Cn $channel, $playlists)
    {
        $this->channel = $channel;
        $this->playlists = $playlists;
    }


    public function broadcastOn()
    {
        return [
            new PresenceChannel('channel.' . $this->channel->name)
        ];
    }
}
