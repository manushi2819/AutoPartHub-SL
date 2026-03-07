<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    protected $fillable = [
        'customer_id',
        'activity_type',
        'reference_id',
        'value'
    ];
}