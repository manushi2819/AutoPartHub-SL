<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;
use App\Models\VendorCommissionSettlementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorCommissionSubmitController extends Controller
{
    
    public function index(Request $request)
    {
        $vendorId = session('vendor_id');

        $commissions = VendorCommission::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->orderBy('created_at')
            ->get();

        $periodStart = $commissions->min('created_at');
        $periodEnd = $commissions->max('created_at');

        $history = VendorCommissionSettlement::where('vendor_id', $vendorId)
            ->cod()->latest('created_at')->paginate(15);

        $tab = $request->get('tab', 'pending');

        return view('VendorDashboard.Commissions.submit', compact('commissions', 'periodStart', 'periodEnd', 'history', 'tab'));
    }

    public function submit(Request $request)
    {
        $vendorId = session('vendor_id');

        $request->validate([
            'commission_ids' => 'required|array|min:1',
            'commission_ids.*' => 'exists:vendor_commissions,id',
            'transfer_reference' => 'nullable|string|max:255',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $commissions = VendorCommission::where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->whereIn('id', $request->commission_ids)
            ->get();

        if ($commissions->isEmpty()) {
            return back()->with('error', 'No valid pending commissions selected. Items must be delivered before settlement.');
        }

        $slipName = time() . '_cod_slip.' . $request->file('payment_slip')->getClientOriginalExtension();
        $request->file('payment_slip')->move(public_path('uploads/vendor-commissions'), $slipName);

        DB::transaction(function () use ($commissions, $vendorId, $request, $slipName) {
            $settlement = VendorCommissionSettlement::create([
                'vendor_id' => $vendorId,
                'payment_method' => 'cod',
                'total_amount' => $commissions->sum('commission_amount'),
                'payment_slip' => 'uploads/vendor-commissions/' . $slipName,
                'transfer_reference' => $request->transfer_reference,
                'status' => 'submitted',
                'period_start' => $commissions->min('created_at')->toDateString(),
                'period_end' => $commissions->max('created_at')->toDateString(),
                'submitted_by' => $vendorId,
                'submitted_at' => now(),
            ]);

            // ⚠️ Important: we do NOT change commission row status here.
            // It stays 'pending' until admin approves. Otherwise a rejected
            // submission would have nowhere clean to fall back to.
            foreach ($commissions as $commission) {
                VendorCommissionSettlementItem::create([
                    'settlement_id' => $settlement->id,
                    'vendor_commission_id' => $commission->id,
                ]);
            }
        });

        return back()->with('success', 'Commission slip submitted for admin review.');
    }
}