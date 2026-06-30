<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;
use Illuminate\Http\Request;

class VendorCommissionCardViewController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = session('vendor_id');

        $pending = VendorCommission::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->orderBy('created_at')
            ->get();

        $settlements = VendorCommissionSettlement::where('vendor_id', $vendorId)
            ->card()
            ->latest('reviewed_at')
            ->paginate(15);

        $tab = $request->get('tab', 'pending');

        return view('VendorDashboard.Commissions.card_index', compact('pending', 'settlements', 'tab'));
    }
}