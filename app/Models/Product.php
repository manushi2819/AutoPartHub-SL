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


    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class)->where('status', 'approved')->with('images');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0; 
    }

    public function reviewsCount()
    {
        return $this->reviews()->count(); 
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}


