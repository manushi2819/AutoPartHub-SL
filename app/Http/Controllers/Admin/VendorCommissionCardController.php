<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;
use App\Models\VendorCommissionSettlementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorCommissionCardController extends Controller
{

    public function index(Request $request)
    {
        $vendors = Vendor::where('id', '!=', 1)
            ->whereHas('commissions', function ($q) {
                $q->where('payment_method', 'card')->where('status', 'pending')
                ->whereHas('orderItem', fn($q2) => $q2->where('status', 'delivered'));
            })
            ->withSum(['commissions as pending_total' => function ($q) {
                $q->where('payment_method', 'card')->where('status', 'pending')
                ->whereHas('orderItem', fn($q2) => $q2->where('status', 'delivered'));
            }], 'commission_amount')
            ->get();

        $settlements = VendorCommissionSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->card()
            ->latest('reviewed_at')
            ->paginate(20);

        $tab = $request->get('tab', 'pending');

        return view('AdminDashboard.VendorPayments.commissions_card_index', compact('vendors', 'settlements', 'tab'));
    }

    public function showVendor(Vendor $vendor)
    {
        $commissions = VendorCommission::with('order', 'product')
            ->where('vendor_id', $vendor->id)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->orderBy('created_at')
            ->get();

        $periodStart = $commissions->min('created_at');
        $periodEnd = $commissions->max('created_at');

        return view('AdminDashboard.VendorPayments.commissions_card_settle', compact('vendor', 'commissions', 'periodStart', 'periodEnd'));
    }

    // Admin acknowledges these card commissions as already-retained — no slip needed
    public function settle(Request $request, Vendor $vendor)
    {
        $request->validate([
            'commission_ids' => 'required|array|min:1',
            'commission_ids.*' => 'exists:vendor_commissions,id',
            'notes' => 'nullable|string',
        ]);

        $commissions = VendorCommission::where('vendor_id', $vendor->id)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->whereIn('id', $request->commission_ids)
            ->get();

        if ($commissions->isEmpty()) {
            return back()->with('error', 'No valid pending commissions selected. Items must be delivered before settlement.');
        }

        DB::transaction(function () use ($commissions, $vendor, $request) {
            $settlement = VendorCommissionSettlement::create([
                'vendor_id' => $vendor->id,
                'payment_method' => 'card',
                'total_amount' => $commissions->sum('commission_amount'),
                'status' => 'paid',
                'period_start' => $commissions->min('created_at')->toDateString(),
                'period_end' => $commissions->max('created_at')->toDateString(),
                'reviewed_by' => session('admin_id', 0),
                'reviewed_at' => now(),
            ]);

            foreach ($commissions as $commission) {
                VendorCommissionSettlementItem::create([
                    'settlement_id' => $settlement->id,
                    'vendor_commission_id' => $commission->id,
                ]);
                $commission->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                    'settled_by' => session('admin_id', 0),
                ]);
            }
        });

        return redirect()->route('admin.vendor-commissions-card.index')->with('success', 'Card commissions marked as settled.');
    }
}