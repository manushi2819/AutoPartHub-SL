<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewAuctionBid implements ShouldBroadcast
{
    public $bid;

    public function __construct($bid)
    {
        $this->bid = $bid;
    }

    public function broadcastOn()
    {
        return new Channel('auction.' . $this->bid->auction_id);
    }

    public function broadcastAs()
    {
        return 'new-bid';
    }
}