<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketListUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        //initalize the ticket object.
        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
        return new Channel('my-channel');
    }

    public function broadcastWith(){
        return [
            'id' => 'same',
            'fname' => '$this->ticket->user_id',
            'lname' => '$this->ticket->type',
            'score' => '$this->ticket->content'
        ];
    }
}
