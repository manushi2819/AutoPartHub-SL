<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

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
        $totalOrders = Order::count();

        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Only PAID income
        $totalIncome = Order::where('payment_status', 'paid')
                            ->sum('total');

        $todayIncome = Order::where('payment_status', 'paid')
                            ->whereDate('updated_at', Carbon::today())
                            ->sum('total');

        // -----------------------
        // Last 12 Months Data
        // -----------------------
        $months = [];
        $salesData = [];
        $earningsData = [];

        for ($i = 11; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            // Orders count
            $salesData[] = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // Paid earnings only
            $earningsData[] = Order::where('payment_status', 'paid')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->sum('total');
        }

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
            'earningsData'
        ));
    }
}