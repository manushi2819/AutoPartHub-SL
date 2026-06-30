<?php
// app/Models/VendorCommissionSettlementItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCommissionSettlementItem extends Model
{
    protected $fillable = ['settlement_id', 'vendor_commission_id'];
}