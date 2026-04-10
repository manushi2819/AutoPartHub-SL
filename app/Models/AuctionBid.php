<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    protected $fillable = [
        'auction_id',
        'customer_id',
        'bid_amount',
        'bid_time',
        'is_winner'
    ];

    protected $casts = [
        'bid_time' => 'datetime',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}