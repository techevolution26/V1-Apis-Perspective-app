<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class NewMessage implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
    * Create a new event instance.
    */

    public function __construct( public Message $message ) {
        //
    }

    /**
    * Get the channels the event should broadcast on.
    *
    * @return array<int, \Illuminate\Broadcasting\Channel>
    */

    public function broadcastOn(): Channel {
        // drop the 'private-' prefix and make it a public channel:
        return new Channel( 'conversations.'.$this->message->to_user_id );
    }

    public function broadcastWith() {
        return [
            'message' => $this->message->toArray()
        ];
    }
}
