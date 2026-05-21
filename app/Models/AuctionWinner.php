<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionWinner extends Model
{
    protected $fillable = [
        'auction_id',
        'winner_id',
        'winner_bid_id',
        'winner_price',
        'status',
        'rejection_reason'
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function winner()
    {
        return $this->belongsTo(Customer::class, 'winner_id');
    }

    public function bid()
    {
        return $this->belongsTo(AuctionBid::class, 'winner_bid_id');
    }
}