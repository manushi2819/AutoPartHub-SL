<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\VendorEarning;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // -----------------------
        // Dashboard Counts
        // -----------------------
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();

        // Only orders that include at least one item from admin's own store (vendor_id 1)
        $totalOrders = Order::whereHas('items', fn($q) => $q->where('vendor_id', 1))->count();

        $todayOrders = Order::whereHas('items', fn($q) => $q->where('vendor_id', 1))
            ->whereDate('created_at', Carbon::today())
            ->count();

        // -----------------------
        // Admin Income = full revenue from admin's own store (vendor_id 1)
        //               + commission earned on every other vendor's sale
        // -----------------------
        $totalIncome = $this->calculateIncome();
        $todayIncome = $this->calculateIncome(Carbon::today(), Carbon::today());

        // -----------------------
        // Last 12 Months Data
        // -----------------------
        $months = [];
        $salesData = [];
        $earningsData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            // Orders count, scoped to admin's own store only
            $salesData[] = Order::whereHas('items', fn($q) => $q->where('vendor_id', 1))
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $earningsData[] = $this->calculateIncome($monthStart, $monthEnd);
        }

        // -----------------------
        // Vendor Finance Summary (excludes vendor_id 1, the admin's own store)
        // -----------------------
        $pendingVendorEarnings = VendorEarning::where('vendor_id', '!=', 1)
            ->where('status', 'pending')
            ->sum('earning_amount');

        $pendingCardCommissions = VendorCommission::where('vendor_id', '!=', 1)
            ->where('payment_method', 'card')
            ->where('status', 'pending')
            ->sum('commission_amount');

        $pendingCodCommissions = VendorCommission::where('vendor_id', '!=', 1)
            ->where('payment_method', 'cod')
            ->where('status', 'pending')
            ->sum('commission_amount');

        $codSettlementsAwaitingReview = VendorCommissionSettlement::where('vendor_id', '!=', 1)
            ->where('payment_method', 'cod')
            ->where('status', 'submitted')
            ->get();

        $codAwaitingReviewCount = $codSettlementsAwaitingReview->count();
        $codAwaitingReviewTotal = $codSettlementsAwaitingReview->sum('total_amount');

        return view('AdminDashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'todayOrders',
            'totalIncome',
            'todayIncome',
            'months',
            'salesData',
            'earningsData',
            'pendingVendorEarnings',
            'pendingCardCommissions',
            'pendingCodCommissions',
            'codAwaitingReviewCount',
            'codAwaitingReviewTotal'
        ));
    }

    /**
     * Admin's real income for an optional date range:
     * full earnings from the admin's own store (vendor_id 1, no status check)
     * + commission earned on every order item across all vendors.
     */
    private function calculateIncome(?Carbon $start = null, ?Carbon $end = null): float
    {
        $ownStoreQuery = OrderItem::where('vendor_id', 1);
        $commissionQuery = OrderItem::query();

        if ($start && $end) {
            $ownStoreQuery->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
            $commissionQuery->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
        }

        $ownStoreEarnings = $ownStoreQuery->sum('vendor_earning_amount');
        $allVendorCommissions = $commissionQuery->sum('vendor_commission_amount');

        return (float) ($ownStoreEarnings + $allVendorCommissions);
    }
}