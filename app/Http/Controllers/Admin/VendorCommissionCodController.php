<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorCommissionSettlement;
use App\Models\VendorCommissionSettlementItem;
use App\Models\Vendor;
use App\Models\VendorCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorCommissionCodController extends Controller
{
    
    public function index(Request $request)
    {
        // 1. Pending commissions (not submitted by vendor)
        $pendingCommissions = VendorCommission::with([
            'vendor',
            'order',
            'orderItem.product'
        ])
        ->where('vendor_id', '!=', 1)
        ->where('payment_method', 'cod')
        ->where('status', 'pending')
        ->whereHas('orderItem', function ($q) {
            $q->where('status', '!=', 'pending');
        })
        ->latest()
        ->get();


        // 2. Submitted settlements waiting for admin
        $pending = VendorCommissionSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->cod()
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->get();


        // 3. Paid / rejected history
        $history = VendorCommissionSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->cod()
            ->whereIn('status', ['paid', 'rejected'])
            ->latest('reviewed_at')
            ->paginate(20);


        $tab = $request->get('tab', 'pending_commissions');


        return view(
            'AdminDashboard.VendorPayments.commissions_cod_index',
            compact(
                'pendingCommissions',
                'pending',
                'history',
                'tab'
            )
        );
    }



    public function show(VendorCommissionSettlement $settlement)
    {
        $settlement->load('vendor', 'commissions.product', 'commissions.order');
        return view('AdminDashboard.VendorPayments.commissions_cod_review', compact('settlement'));
    }

    public function approve(Request $request, VendorCommissionSettlement $settlement)
    {
        if ($settlement->status !== 'submitted') {
            return back()->with('error', 'This settlement has already been reviewed.');
        }

        DB::transaction(function () use ($settlement) {
            $settlement->update([
                'status' => 'paid',
                'reviewed_by' => session('admin_id', 0),
                'reviewed_at' => now(),
            ]);

            $settlement->update([
                    'status'  => 'paid',
                    'settled_by' => session('admin_id', 0),
                ]);
        });

        return back()->with('success', 'Commission settlement approved.');
    }

    public function reject(Request $request, VendorCommissionSettlement $settlement)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        if ($settlement->status !== 'submitted') {
            return back()->with('error', 'This settlement has already been reviewed.');
        }
        $settlement->update([
            'status' => 'rejected',
            'reviewed_by' => session('admin_id', 0),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Settlement rejected. Vendor can resubmit.');
    }


    // Show manual settlement form for a suspended vendor (admin uploads slip on vendor's behalf)
    public function settleManualForm(Vendor $vendor)
    {
        $commissions = VendorCommission::with('order', 'orderItem.product')
            ->where('vendor_id', $vendor->id)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', '!=', 'pending'))
            ->orderBy('created_at')
            ->get();

        $periodStart = $commissions->min('created_at');
        $periodEnd = $commissions->max('created_at');

        return view('AdminDashboard.VendorPayments.commissions_cod_settle_manual', compact('vendor', 'commissions', 'periodStart', 'periodEnd'));
    }

    // Process manual settlement + reactivate vendor
    public function settleManualStore(Request $request, Vendor $vendor)
    {
        $request->validate([
            'commission_ids' => 'required|array|min:1',
            'commission_ids.*' => 'exists:vendor_commissions,id',
            'transfer_reference' => 'nullable|string|max:255',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        $commissions = VendorCommission::where('vendor_id', $vendor->id)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->whereIn('id', $request->commission_ids)
            ->get();

        if ($commissions->isEmpty()) {
            return back()->with('error', 'No valid pending commissions selected.');
        }

        $slipName = time() . '_manual_slip.' . $request->file('payment_slip')->getClientOriginalExtension();
        $request->file('payment_slip')->move(public_path('uploads/vendor-commissions'), $slipName);

        DB::transaction(function () use ($commissions, $vendor, $request, $slipName) {
            $settlement = VendorCommissionSettlement::create([
                'vendor_id' => $vendor->id,
                'payment_method' => 'cod',
                'total_amount' => $commissions->sum('commission_amount'),
                'transfer_reference' => $request->transfer_reference,
                'payment_slip' => 'uploads/vendor-commissions/' . $slipName,
                'period_start' => $commissions->min('created_at')->toDateString(),
                'period_end' => $commissions->max('created_at')->toDateString(),
                'status' => 'paid', // admin-confirmed, so mark directly as paid — skips 'submitted' review step
                'reviewed_by' => session('admin_id', 1),
                'reviewed_at' => now(),
                'submitted_at' => now(),
                'notes' => ($request->notes ? $request->notes . ' | ' : '') . 'Settled manually by admin (offline payment).',
            ]);

            foreach ($commissions as $commission) {
                VendorCommissionSettlementItem::create([
                    'settlement_id' => $settlement->id,
                    'vendor_commission_id' => $commission->id,
                ]);

                $commission->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }

            // ✅ Reactivate the vendor since they've cleared their dues
            $vendor->update(['status' => 'Approved']);
        });

        return redirect()->route('admin.vendor-commissions-cod.index')
            ->with('success', 'Commissions settled manually and vendor account reactivated.');
    }
}