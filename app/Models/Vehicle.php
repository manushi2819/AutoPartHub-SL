<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand_id',
        'model',
        'year',
        'price',
        'mileage',
        'condition',
        'fuel_type',
        'transmission',
        'engine_cc',
        'body_type',
        'color',
        'district',
        'city',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Brand relationship
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Images relationship
    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    // Main image (optional helper)
    public function mainImage()
    {
        return $this->hasOne(VehicleImage::class)->where('is_main', 1);
    }
}