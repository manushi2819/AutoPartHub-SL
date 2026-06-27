<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = session('vendor_id');

        // =========================
        // PRODUCTS (Vendor only)
        // =========================
        $totalProducts = Product::where('vendor_id', $vendorId)->count();

        // =========================
        // ORDERS (via order_items)
        // =========================
        $totalOrders = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->distinct('order_id')
            ->count('order_id');

        $todayOrders = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->whereHas('order', function ($q) {
                $q->whereDate('created_at', Carbon::today());
            })
            ->distinct('order_id')
            ->count('order_id');

        // =========================
        // INCOME (ONLY THIS VENDOR PRODUCTS)
        // =========================
        $totalIncome = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->sum('subtotal');

        $todayIncome = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->whereHas('order', function ($q) {
                $q->whereDate('updated_at', Carbon::today());
            })
            ->sum('subtotal');

        // =========================
        // MONTHLY ANALYTICS
        // =========================
        $months = [];
        $salesData = [];
        $earningsData = [];

        for ($i = 11; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            // Orders per month
            $salesData[] = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                    $q->where('vendor_id', $vendorId);
                })
                ->whereHas('order', function ($q) use ($date) {
                    $q->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);
                })
                ->distinct('order_id')
                ->count('order_id');

            // Earnings per month
            $earningsData[] = OrderItem::whereHas('product', function ($q) use ($vendorId) {
                    $q->where('vendor_id', $vendorId);
                })
                ->whereHas('order', function ($q) use ($date) {
                    $q->where('payment_status', 'paid')
                      ->whereYear('updated_at', $date->year)
                      ->whereMonth('updated_at', $date->month);
                })
                ->sum('subtotal');
        }

        return view('VendorDashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'todayOrders',
            'totalIncome',
            'todayIncome',
            'months',
            'salesData',
            'earningsData'
        ));
    }
}