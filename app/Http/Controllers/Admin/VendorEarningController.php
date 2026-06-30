<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorEarning;
use App\Models\VendorEarningSettlement;
use App\Models\VendorEarningSettlementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorEarningController extends Controller
{
    // List vendors with their pending earnings totals
    public function index(Request $request)
    {
        $vendors = Vendor::where('id', '!=', 1)
            ->whereHas('earnings', function ($q) {
                $q->where('status', 'pending')
                ->whereHas('orderItem', fn($q2) => $q2->where('status', 'delivered'));
            })
            ->withSum(['earnings as pending_total' => function ($q) {
                $q->where('status', 'pending')
                ->whereHas('orderItem', fn($q2) => $q2->where('status', 'delivered'));
            }], 'earning_amount')
            ->get();

        $settlements = VendorEarningSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->latest('paid_at')
            ->get();

        $tab = $request->get('tab', 'pending');

        return view('AdminDashboard.VendorPayments.earnings_index', compact('vendors', 'settlements', 'tab'));
    }


    // Show pending earning rows for one vendor, selectable before settling
    public function showVendor(Vendor $vendor)
    {
        $earnings = VendorEarning::with('order', 'product')
            ->where('vendor_id', $vendor->id)
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->orderBy('created_at')
            ->get();

        $periodStart = $earnings->min('created_at');
        $periodEnd = $earnings->max('created_at');

        return view('AdminDashboard.VendorPayments.earnings_settle', compact('vendor', 'earnings', 'periodStart', 'periodEnd'));
    }

    // Process the settlement for selected rows
    public function settle(Request $request, Vendor $vendor)
    {
        $request->validate([
            'earning_ids' => 'required|array|min:1',
            'earning_ids.*' => 'exists:vendor_earnings,id',
            'transfer_reference' => 'nullable|string|max:255',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        // ✅ Re-check delivered status server-side — never trust the selected IDs blindly,
        // since the displayed list could be stale by the time the form is submitted.
        $earnings = VendorEarning::where('vendor_id', $vendor->id)
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->whereIn('id', $request->earning_ids)
            ->get();

        if ($earnings->isEmpty()) {
            return back()->with('error', 'No valid pending earnings selected. Items must be delivered before settlement.');
        }

        $slipName = time() . '_slip.' . $request->file('payment_slip')->getClientOriginalExtension();
        $request->file('payment_slip')->move(public_path('uploads/vendor-earnings'), $slipName);

        DB::transaction(function () use ($earnings, $vendor, $request, $slipName) {
            $settlement = VendorEarningSettlement::create([
                'vendor_id' => $vendor->id,
                'total_amount' => $earnings->sum('earning_amount'),
                'transfer_reference' => $request->transfer_reference,
                'payment_slip' => 'uploads/vendor-earnings/' . $slipName,
                'period_start' => $earnings->min('created_at')->toDateString(),
                'period_end' => $earnings->max('created_at')->toDateString(),
                'paid_by' => session('admin_id', 0),
                'paid_at' => now(),
                'notes' => $request->notes,
            ]);

           foreach ($earnings as $earning) {
                VendorEarningSettlementItem::create([
                    'settlement_id' => $settlement->id,
                    'vendor_earning_id' => $earning->id,
                ]);

                $earning->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                    'paid_by' => session('admin_id', 0),
                ]);
            }
        });

        return redirect()->route('admin.vendor-earnings.index')->with('success', 'Earnings settled and slip uploaded.');
    }


    public function settlementShow(VendorEarningSettlement $settlement)
    {
        $settlement->load('vendor', 'earnings.product', 'earnings.order');
        return view('AdminDashboard.VendorPayments.earnings_settlement_show', compact('settlement'));
    }
}