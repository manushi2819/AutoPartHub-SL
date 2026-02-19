<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVehicleCompatibility extends Model
{
    protected $fillable = [
        'product_id',
        'brand',
        'model',
        'year_from',
        'year_to',
        'engine_type',
        'engine_cc',
        'fuel_type',
        'transmission',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
