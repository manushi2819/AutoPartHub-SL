<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\VendorEarning;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;
use Carbon\Carbon;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = session('vendor_id');

        // =========================
        // PRODUCTS
        // =========================
        $totalProducts = Product::where('vendor_id', $vendorId)->count();

        // =========================
        // ORDERS (distinct orders containing this vendor's items)
        // =========================
        $totalOrders = OrderItem::where('vendor_id', $vendorId)
            ->distinct('order_id')
            ->count('order_id');

        $todayOrders = OrderItem::where('vendor_id', $vendorId)
            ->whereDate('created_at', Carbon::today())
            ->distinct('order_id')
            ->count('order_id');

        // =========================
        // INCOME = vendor's actual earning (after commission), on paid items only
        // =========================
        $totalIncome = $this->calculateIncome($vendorId);
        $todayIncome = $this->calculateIncome($vendorId, Carbon::today(), Carbon::today());

        // =========================
        // MONTHLY ANALYTICS
        // =========================
        $months = [];
        $salesData = [];
        $earningsData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            $salesData[] = OrderItem::where('vendor_id', $vendorId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->distinct('order_id')
                ->count('order_id');

            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $earningsData[] = $this->calculateIncome($vendorId, $monthStart, $monthEnd);
        }

        // =========================
        // Vendor Finance Summary
        // =========================
        $pendingEarnings = VendorEarning::where('vendor_id', $vendorId)
            ->where('status', 'pending')
            ->sum('earning_amount');

        $pendingCardCommissions = VendorCommission::where('vendor_id', $vendorId)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->sum('commission_amount');

        $pendingCodCommissions = VendorCommission::where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->sum('commission_amount');

        $codSettlementsAwaitingReview = VendorCommissionSettlement::where('vendor_id', $vendorId)
            ->where('payment_method', 'cod')
            ->where('status', 'submitted')
            ->count();

        return view('VendorDashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'todayOrders',
            'totalIncome',
            'todayIncome',
            'months',
            'salesData',
            'earningsData',
            'pendingEarnings',
            'pendingCardCommissions',
            'pendingCodCommissions',
            'codSettlementsAwaitingReview'
        ));
    }

    /**
     * Vendor's actual income: sum of vendor_earning_amount on this vendor's
     * paid order items, for an optional date range.
     */
    private function calculateIncome(int $vendorId, ?Carbon $start = null, ?Carbon $end = null): float
    {
        $query = OrderItem::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid');

        if ($start && $end) {
            $query->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
        }

        return (float) $query->sum('vendor_earning_amount');
    }
}