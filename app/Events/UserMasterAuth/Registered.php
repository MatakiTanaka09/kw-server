<?php
declare(strict_types=1);

namespace App\Events\UserMasterAuth;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use KW\Infrastructure\Eloquents\UserMaster;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userMaster;

    /**
     * Registered constructor.
     * @param $userMaster
     */
    public function __construct($userMaster)
    {
        $this->userMaster = $userMaster;
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
