<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorCommission;

class VendorCommissionCardViewController extends Controller
{
    public function index()
    {
        $vendorId = session('vendor_id');

        $commissions = VendorCommission::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->where('payment_method', 'card')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('VendorDashboard.Commissions.card_index', compact('commissions'));
    }
}