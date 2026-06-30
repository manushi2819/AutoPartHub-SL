<?php
// app/Models/VendorEarningSettlementItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEarningSettlementItem extends Model
{
    protected $fillable = ['settlement_id', 'vendor_earning_id'];
}