<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEarning extends Model
{
    protected $fillable = [
        'order_id', 'order_item_id', 'vendor_id', 'product_id',
        'payment_method', 'earning_amount', 'status',
        'paid_at', 'paid_by', 'notes',
    ];

    protected $casts = [
        'earning_amount' => 'decimal:2',
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

    public function settlements()
    {
        return $this->belongsToMany(VendorEarningSettlement::class, 'vendor_earning_settlement_items', 'vendor_earning_id', 'settlement_id');
    }

}