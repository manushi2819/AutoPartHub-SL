<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'tracking_no',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'zip',
        'country',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'status',
        'payment_status',
    ];

    // Relationship to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}