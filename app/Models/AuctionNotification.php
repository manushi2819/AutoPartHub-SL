<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionNotification extends Model
{
    protected $fillable = [
        'auction_id',
        'customer_id',
        'type',
        'sent_at'
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