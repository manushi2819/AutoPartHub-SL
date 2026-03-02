<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'session_id',
    ];

    // Relation to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relation to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}