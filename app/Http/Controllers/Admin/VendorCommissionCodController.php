<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorCommissionSettlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorCommissionCodController extends Controller
{
    
    public function index(Request $request)
    {
        $pending = VendorCommissionSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->cod()->where('status', 'submitted')
            ->latest('submitted_at')->get();

        $history = VendorCommissionSettlement::with('vendor')
            ->where('vendor_id', '!=', 1)
            ->cod()->whereIn('status', ['paid', 'rejected'])
            ->latest('reviewed_at')->paginate(20);

        $tab = $request->get('tab', 'pending');

        return view('AdminDashboard.VendorPayments.commissions_cod_index', compact('pending', 'history', 'tab'));
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
}