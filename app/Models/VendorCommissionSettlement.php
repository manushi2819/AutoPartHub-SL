<?php
// app/Models/VendorCommissionSettlement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCommissionSettlement extends Model
{
    protected $fillable = [
        'vendor_id', 'payment_method', 'total_amount', 'payment_slip', 'transfer_reference',
        'status', 'period_start', 'period_end',
        'submitted_by', 'submitted_at', 'reviewed_by', 'reviewed_at', 'rejection_reason',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function commissions()
    {
        return $this->belongsToMany(VendorCommission::class, 'vendor_commission_settlement_items', 'settlement_id', 'vendor_commission_id');
    }

    public function scopeCard($q) { return $q->where('payment_method', 'card'); }
    public function scopeCod($q) { return $q->where('payment_method', 'cod'); }
}