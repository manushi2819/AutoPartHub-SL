<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     protected $fillable = [
        'name',
        'status',
        'image',
    ];

     protected $casts = [
        'status' => 'boolean', 
    ];

     public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
