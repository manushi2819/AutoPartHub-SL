<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorEarning;
use App\Models\VendorEarningSettlement;
use Illuminate\Http\Request;

class VendorEarningViewController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = session('vendor_id');

        $pending = VendorEarning::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->orderBy('created_at')
            ->get();

        $settlements = VendorEarningSettlement::where('vendor_id', $vendorId)
            ->latest('paid_at')
            ->paginate(15);

        $tab = $request->get('tab', 'pending');

        return view('VendorDashboard.Earnings.index', compact('pending', 'settlements', 'tab'));
    }


    public function settlementShow(VendorEarningSettlement $settlement)
    {
        $vendorId = session('vendor_id');
        $settlement->load('earnings.product', 'earnings.order');
        return view('VendorDashboard.Earnings.settlement_show', compact('settlement'));
    }


     public function codindex(Request $request)
    {
        $vendorId = session('vendor_id');

        $pending = VendorEarning::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->whereHas('orderItem', function ($q) {
                $q->where('status', '!=', 'pending');
            })
            ->orderBy('created_at')
            ->get();

        $paid = VendorEarning::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'paid')
            ->orderBy('created_at')
            ->get();

        $tab = $request->get('tab', 'pending');

        return view('VendorDashboard.Earnings.cod-index', compact('pending', 'paid', 'tab'));
    }
}