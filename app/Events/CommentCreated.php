<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Chat;
use App\User;

class CommentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $user;

    public function __construct(Chat $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;  
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('App.User.' . $this->comment->user->id),
            new PresenceChannel('channel.' . $this->comment->channel_name)
            
        ];
        
    }

    public function broadcastWith()
    {
        return [
            'comment' => array_merge($this->comment->toArray(), [
                'user' => $this->comment->user,
            ]),
            'user' => $this->user, 
        ];
    }
}
