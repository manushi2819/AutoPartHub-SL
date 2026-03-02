<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'brand',
        'price',
        'cost_price',
        'description',
        'stock_quantity',
        'small_description',
        'status',
    ];

    // Category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Images relationship
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Vehicle compatibility
    public function compatibility()
    {
        return $this->hasOne(ProductVehicleCompatibility::class);
    }
}
