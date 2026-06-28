<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'vendor_id',
        'vendor_percentage',
        'vendor_commission_amount',
        'vendor_earning_amount',
        'status',
        'payment_status',
        'tracking_no'
    ];

    // Relationship to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}