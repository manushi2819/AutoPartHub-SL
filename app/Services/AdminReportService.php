<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Vendor;
use App\Models\VendorEarning;
use App\Models\VendorCommission;
use App\Models\VendorEarningSettlement;
use App\Models\VendorCommissionSettlement;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AdminReportService
{
    /**
     * INCOME REPORT
     * Total income = own-store earnings (vendor_id 1) + commission earned across all vendors.
     */
    public function incomeReport(?Carbon $start, ?Carbon $end): array
    {
        $itemQuery = OrderItem::query();
        if ($start && $end) {
            $itemQuery->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
        }

        $ownStoreEarnings = (clone $itemQuery)->where('vendor_id', 1)->sum('vendor_earning_amount');
        $totalCommission = (clone $itemQuery)->sum('vendor_commission_amount');
        $totalIncome = (float) $ownStoreEarnings + (float) $totalCommission;

        // Breakdown by vendor (commission generated per vendor, excluding admin's own store)
        $vendorBreakdown = (clone $itemQuery)
            ->where('vendor_id', '!=', 1)
            ->selectRaw('vendor_id, COUNT(DISTINCT order_id) as order_count, SUM(subtotal) as total_sales, SUM(vendor_commission_amount) as total_commission')
            ->groupBy('vendor_id')
            ->with('vendor:id,shop_name,owner_name')
            ->orderByDesc('total_commission')
            ->get();

        $incomeDetails = (clone $itemQuery)
            ->with([
                'vendor:id,shop_name,owner_name',
                'order:id,order_number,created_at'
            ])
            ->orderByDesc('created_at')
            ->get();

        // Breakdown by payment method
        $byCard = (clone $itemQuery)->whereHas('order', fn($q) => $q->where('payment_method', 'card'))
            ->selectRaw('SUM(vendor_earning_amount) as own_store_earning, SUM(vendor_commission_amount) as commission')
            ->where('vendor_id', 1)
            ->first();

        $cardCommissionAll = (clone $itemQuery)->whereHas('order', fn($q) => $q->where('payment_method', 'card'))
            ->sum('vendor_commission_amount');

        $codCommissionAll = (clone $itemQuery)->whereHas('order', fn($q) => $q->where('payment_method', 'cod'))
            ->sum('vendor_commission_amount');

        $cardOwnStore = (clone $itemQuery)->where('vendor_id', 1)
            ->whereHas('order', fn($q) => $q->where('payment_method', 'card'))
            ->sum('vendor_earning_amount');

        $codOwnStore = (clone $itemQuery)->where('vendor_id', 1)
            ->whereHas('order', fn($q) => $q->where('payment_method', 'cod'))
            ->sum('vendor_earning_amount');

        return [
            'period_start' => $start,
            'period_end' => $end,
            'own_store_earnings' => (float) $ownStoreEarnings,
            'total_commission' => (float) $totalCommission,
            'total_income' => $totalIncome,
            'vendor_breakdown' => $vendorBreakdown,
            'card_total' => (float) $cardCommissionAll + (float) $cardOwnStore,
            'cod_total' => (float) $codCommissionAll + (float) $codOwnStore,
            'income_details' => $incomeDetails,
        ];
    }

    /**
     * PENDING COMMISSION REPORT
     * Card = bookkeeping only (already retained). COD = real money vendors still owe admin.
     * Both exclude vendor_id 1 and only count items that are actually delivered.
     */
    public function codCommissionReport(?Carbon $start, ?Carbon $end, ?string $status = null)
    {
        $query = VendorCommission::where('vendor_id', '!=', 1)
            ->where('payment_method', 'cod');

        if ($status) {
            $query->where('status', $status);
        }

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start->copy()->startOfDay(),
                $end->copy()->endOfDay()
            ]);
        }

        $data = (clone $query)
            ->selectRaw('
                vendor_id,
                status,
                COUNT(*) as item_count,
                SUM(commission_amount) as total
            ')
            ->groupBy('vendor_id', 'status')
            ->with('vendor:id,shop_name,address,email,phone,district')
            ->orderByDesc('total')
            ->get();

        return [
            'data' => $data,
            'status' => $status,
            'period_start' => $start,
            'period_end' => $end,
        ];
    }


    /**
     * VENDOR PERFORMANCE / SETTLEMENT REPORT
     * Per-vendor summary across the whole lifecycle: sales, commission generated,
     * earnings paid out vs pending, commission collected vs pending.
     */
    public function vendorPerformanceReport(?Carbon $start, ?Carbon $end): Collection
    {
        $itemQuery = fn() => OrderItem::where('vendor_id', '!=', 1)
            ->when($start && $end, fn($q) => $q->whereBetween('created_at', [
                $start->copy()->startOfDay(), $end->copy()->endOfDay()
            ]));

        $sales = $itemQuery()
            ->selectRaw('vendor_id, COUNT(DISTINCT order_id) as order_count, SUM(subtotal) as total_sales, SUM(vendor_commission_amount) as total_commission_generated')
            ->groupBy('vendor_id')
            ->get()
            ->keyBy('vendor_id');

        $earningsPaid = VendorEarning::where('vendor_id', '!=', 1)->where('status', 'paid')
            ->when($start && $end, fn($q) => $q->whereBetween('paid_at', [$start, $end]))
            ->selectRaw('vendor_id, SUM(earning_amount) as total')->groupBy('vendor_id')->get()->keyBy('vendor_id');

        $earningsPending = VendorEarning::where('vendor_id', '!=', 1)->where('status', 'pending')
            ->selectRaw('vendor_id, SUM(earning_amount) as total')->groupBy('vendor_id')->get()->keyBy('vendor_id');

        $commissionPaid = VendorCommission::where('vendor_id', '!=', 1)->where('status', 'paid')
            ->selectRaw('vendor_id, SUM(commission_amount) as total')->groupBy('vendor_id')->get()->keyBy('vendor_id');

        $commissionPending = VendorCommission::where('vendor_id', '!=', 1)->where('status', 'pending')
            ->selectRaw('vendor_id, SUM(commission_amount) as total')->groupBy('vendor_id')->get()->keyBy('vendor_id');

        $vendorIds = $sales->keys()
            ->merge($earningsPaid->keys())->merge($earningsPending->keys())
            ->merge($commissionPaid->keys())->merge($commissionPending->keys())
            ->unique();

        $vendors = Vendor::whereIn('id', $vendorIds)->get()->keyBy('id');

        return $vendorIds->map(function ($vendorId) use ($sales, $earningsPaid, $earningsPending, $commissionPaid, $commissionPending, $vendors) {
            $vendor = $vendors->get($vendorId);
            return (object) [
                'vendor' => $vendor,
                'order_count' => $sales->get($vendorId)?->order_count ?? 0,
                'total_sales' => $sales->get($vendorId)?->total_sales ?? 0,
                'total_commission_generated' => $sales->get($vendorId)?->total_commission_generated ?? 0,
                'earnings_paid' => $earningsPaid->get($vendorId)?->total ?? 0,
                'earnings_pending' => $earningsPending->get($vendorId)?->total ?? 0,
                'commission_paid' => $commissionPaid->get($vendorId)?->total ?? 0,
                'commission_pending' => $commissionPending->get($vendorId)?->total ?? 0,
            ];
        })->sortByDesc('total_sales')->values();
    }



    public function vendorsReport(?Carbon $start, ?Carbon $end)
    {
        $query = OrderItem::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start->copy()->startOfDay(),
                $end->copy()->endOfDay()
            ]);
        }

        return (clone $query)
            ->where('vendor_id', '!=', 1) // Exclude Admin Store
            ->selectRaw("
                vendor_id,
                COUNT(DISTINCT order_id) as total_orders,
                SUM(subtotal) as total_sales
            ")
            ->groupBy('vendor_id')
            ->with('vendor:id,shop_name,owner_name,address,email,phone,district')
            ->orderByDesc('total_sales')
            ->get();
    }
}