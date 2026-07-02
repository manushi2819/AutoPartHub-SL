<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\VendorEarning;
use App\Models\VendorEarningSettlement;
use App\Models\VendorCommission;
use Carbon\Carbon;

class VendorReportService
{
    /**
     * EARNINGS REPORT
     * Full earning breakdown for the vendor — pending vs paid, per item, plus settlement history.
     */
    public function earningsReport(int $vendorId, ?Carbon $start, ?Carbon $end): array
    {
        $earningQuery = VendorEarning::with('order', 'product')
            ->where('vendor_id', $vendorId)
            ->whereHas('orderItem', function ($q) {
                $q->where('status', '!=', 'pending');
            })
            ->when($start && $end, fn($q) => $q->whereBetween('created_at', [
                $start->copy()->startOfDay(), $end->copy()->endOfDay()
            ]));

        $earnings = (clone $earningQuery)->orderByDesc('created_at')->get();

        $totalEarned    = $earnings->sum('earning_amount');
        $totalPaid      = $earnings->where('status', 'paid')->sum('earning_amount');
        $totalPending   = $earnings->where('status', 'pending')->sum('earning_amount');

        // Only delivered items are actually settlement-eligible right now
        $settleable = VendorEarning::where('vendor_id', $vendorId)
            ->where('status', 'pending')
            ->whereHas('orderItem', fn($q) => $q->where('status', 'delivered'))
            ->sum('earning_amount');

        $settlements = VendorEarningSettlement::where('vendor_id', $vendorId)
            ->when($start && $end, fn($q) => $q->whereBetween('paid_at', [$start, $end]))
            ->latest('paid_at')
            ->get();

        return [
            'period_start'   => $start,
            'period_end'     => $end,
            'earnings'       => $earnings,
            'total_earned'   => (float) $totalEarned,
            'total_paid'     => (float) $totalPaid,
            'total_pending'  => (float) $totalPending,
            'settleable'     => (float) $settleable,
            'settlements'    => $settlements,
        ];
    }

    /**
     * COMMISSION REPORT
     * Card (informational) + COD (actionable with aging).
     */
    public function commissionReport(int $vendorId, ?Carbon $start, ?Carbon $end): array
    {
        $baseQuery = VendorCommission::with([
            'order',
            'product',
            'orderItem'
        ])
        ->where('vendor_id', $vendorId)
        ->whereHas('orderItem', function ($q) {
                $q->where('status', '!=', 'pending');
            });

        if ($start && $end) {
            $baseQuery->whereBetween('created_at', [
                $start->copy()->startOfDay(),
                $end->copy()->endOfDay()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Card Commissions
        |--------------------------------------------------------------------------
        */
        $cardCommissions = (clone $baseQuery)
            ->where('payment_method', 'card')
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | COD Commissions
        |--------------------------------------------------------------------------
        */
        $codCommissions = (clone $baseQuery)
            ->where('payment_method', 'cod')
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Unified Report Rows
        |--------------------------------------------------------------------------
        */
        $reportRows = collect();

        // CARD
        foreach ($cardCommissions as $commission) {
            $reportRows->push([
                'date' => $commission->created_at,
                'type' => 'Card Commission',
                'order_number' => optional($commission->order)->order_number,
                'product' => optional($commission->product)->name,
                'payment_method' => 'Card',
                'amount' => $commission->commission_amount,
                'status' => ucfirst($commission->status),
                'period' => '-',
                'remarks' => 'Retained by Admin',
            ]);
        }

        // COD
        foreach ($codCommissions as $commission) {
            $reportRows->push([
                'date' => $commission->created_at,
                'type' => 'COD Commission',
                'order_number' => optional($commission->order)->order_number,
                'product' => optional($commission->product)->name,
                'payment_method' => 'COD',
                'amount' => $commission->commission_amount,
                'status' => ucfirst($commission->status),
                'period' => '-',
                'remarks' => 'Vendor Payable',
            ]);
        }

        return [
            'period_start' => $start,
            'period_end' => $end,

            'card_total' => (float) $cardCommissions->sum('commission_amount'),
            'card_paid' => (float) $cardCommissions->where('status', 'paid')->sum('commission_amount'),
            'card_pending' => (float) $cardCommissions->where('status', 'pending')->sum('commission_amount'),

            'cod_total' => (float) $codCommissions->sum('commission_amount'),
            'cod_paid' => (float) $codCommissions->where('status', 'paid')->sum('commission_amount'),
            'cod_pending' => (float) $codCommissions->where('status', 'pending')->sum('commission_amount'),

            'report_rows' => $reportRows->sortByDesc('date')->values(),
        ];
    }



    public function payoutReport(int $vendorId, ?Carbon $start, ?Carbon $end): array
    {
        $settlementsQuery = VendorEarningSettlement::where('vendor_id', $vendorId)
            ->when($start && $end, fn($q) => $q->whereBetween('paid_at', [
                $start->copy()->startOfDay(),
                $end->copy()->endOfDay()
            ]));

        $settlements = (clone $settlementsQuery)
            ->latest('paid_at')
            ->get();

        return [
            'period_start' => $start,
            'period_end' => $end,
            'settlements' => $settlements,
            'total_paid' => (float) $settlements->sum('total_amount'),
        ];
    }

    /**
     * SALES SUMMARY
     * Revenue, earnings, commission, product breakdown, monthly trend, payment method split.
     */
    public function salesSummary(int $vendorId, ?Carbon $start, ?Carbon $end): array
    {
        $itemQuery = fn() => OrderItem::with(['product', 'order'])
            ->where('vendor_id', $vendorId)
            ->where('status', '!=', 'pending')
            ->when($start && $end, fn($q) => $q->whereBetween('created_at', [
                $start->copy()->startOfDay(), $end->copy()->endOfDay()
            ]));

        $items = $itemQuery()->get();

        $totalRevenue    = (float) $items->sum('subtotal');
        $totalCommission = (float) $items->sum('vendor_commission_amount');
        $totalEarnings   = (float) $items->sum('vendor_earning_amount');
        $totalOrders     = $items->pluck('order_id')->unique()->count();
        $effectiveRate   = $totalRevenue > 0 ? round(($totalCommission / $totalRevenue) * 100, 2) : 0;

        // Product breakdown
        $productBreakdown = $itemQuery()
            ->selectRaw('product_id,
                          SUM(quantity) as total_units,
                          SUM(subtotal) as total_revenue,
                          SUM(vendor_commission_amount) as total_commission,
                          SUM(vendor_earning_amount) as total_earning')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->get();

        // Monthly trend — always 6 months within the selected range regardless of how wide the range is
        $monthlyTrend = [];
        $rangeStart = $start ?? Carbon::now()->subMonths(5)->startOfMonth();
        $rangeEnd   = $end ?? Carbon::now()->endOfMonth();
        $cursor = $rangeStart->copy()->startOfMonth();

        while ($cursor->lte($rangeEnd)) {
            $monthItems = $items->filter(function ($item) use ($cursor) {
                return $item->created_at->year === $cursor->year
                    && $item->created_at->month === $cursor->month;
            });

            $monthlyTrend[] = [
                'month'      => $cursor->format('M Y'),
                'orders'     => $monthItems->pluck('order_id')->unique()->count(),
                'revenue'    => (float) $monthItems->sum('subtotal'),
                'commission' => (float) $monthItems->sum('vendor_commission_amount'),
                'earning'    => (float) $monthItems->sum('vendor_earning_amount'),
            ];

            $cursor->addMonth();
        }

        $orderDetails = $itemQuery()
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->created_at,
                    'order_number' => optional($item->order)->order_number,
                    'customer_name' => optional($item->order)->first_name . ' ' . optional($item->order)->last_name,
                    'customer_contact' => optional($item->order)->phone . ' / ' . optional($item->order)->email,
                    'customer_address' => optional($item->order)->address,
                    'product' => optional($item->product)->name ?? 'Product #' . $item->product_id,
                    'quantity' => (int) $item->quantity,
                    'payment_method' => optional($item->order)->payment_method,
                    'revenue' => (float) $item->subtotal,
                    'commission' => (float) $item->vendor_commission_amount,
                    'earning' => (float) $item->vendor_earning_amount,
                    'status' => $item->status,
                ];
            })
            ->sortByDesc('date')
            ->values();

        // Payment method split
        $cardItems = $itemQuery()->whereHas('order', fn($q) => $q->where('payment_method', 'card'))->get();
        $codItems  = $itemQuery()->whereHas('order', fn($q) => $q->where('payment_method', 'cod'))->get();

        return [
            'period_start'      => $start,
            'period_end'        => $end,
            'total_orders'      => $totalOrders,
            'total_revenue'     => $totalRevenue,
            'total_commission'  => $totalCommission,
            'total_earnings'    => $totalEarnings,
            'effective_rate'    => $effectiveRate,
            'product_breakdown' => $productBreakdown,
            'monthly_trend'     => $monthlyTrend,
            'order_details'     => $orderDetails,
            'card_revenue'      => (float) $cardItems->sum('subtotal'),
            'card_earning'      => (float) $cardItems->sum('vendor_earning_amount'),
            'cod_revenue'       => (float) $codItems->sum('subtotal'),
            'cod_earning'       => (float) $codItems->sum('vendor_earning_amount'),
        ];
    }
}