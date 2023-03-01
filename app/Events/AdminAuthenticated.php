<?php

namespace App\Events;

use App\Models\Admin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class AdminAuthenticated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admins;

    public $ip;

    public $headers;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admins, Request $request)
    {
        $this->admins = $admins;
        $this->ip = $request->ip();
        $this->headers = $request->headers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
