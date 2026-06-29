<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCommission extends Model
{
    protected $fillable = [
        'order_id', 'order_item_id', 'vendor_id', 'product_id',
        'payment_method', 'commission_amount', 'status',
        'paid_at', 'settled_by', 'notes',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}