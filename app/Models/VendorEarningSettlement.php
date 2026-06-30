<?php
// app/Models/VendorEarningSettlement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEarningSettlement extends Model
{
    protected $fillable = [
        'vendor_id', 'total_amount', 'transfer_reference', 'payment_slip',
        'period_start', 'period_end', 'paid_by', 'paid_at', 'notes',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(VendorEarningSettlementItem::class, 'settlement_id');
    }

    public function earnings()
    {
        return $this->belongsToMany(VendorEarning::class, 'vendor_earning_settlement_items', 'settlement_id', 'vendor_earning_id');
    }
}