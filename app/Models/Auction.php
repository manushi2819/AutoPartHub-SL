<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Auction extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'start_time',
        'end_time',
        'starting_price',
        'bid_increment',
        'status',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

      // Dynamic status
    public function getCurrentStatusAttribute()
    {
        $now = now();

        if ($this->end_time <= $now) {
            return 'ended';
        } elseif ($this->start_time <= $now) {
            return 'active';
        } else {
            return 'upcoming';
        }
    }

    // Relationships
    public function bids()
    {
        return $this->hasMany(AuctionBid::class);
    }

    public function highestBid()
    {
        return $this->hasOne(AuctionBid::class)->latestOfMany('bid_amount');
    }

    // Dynamic relation (Vehicle or Product)
    public function item()
    {
        if ($this->item_type === 'vehicle') {
            return $this->belongsTo(Vehicle::class, 'item_id');
        }

        return $this->belongsTo(Product::class, 'item_id');
    }

}