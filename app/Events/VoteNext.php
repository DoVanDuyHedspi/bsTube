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

class VoteNext implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $vote_next;

    public function __construct(Cn $channel, $vote_next)
    {
        $this->channel = $channel;
        $this->vote_next = $vote_next;
    }

    public function broadcastOn()
    {
        return [
            new PresenceChannel('channel.' . $this->channel->name)
        ];
    }
}
