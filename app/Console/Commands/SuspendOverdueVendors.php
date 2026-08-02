<?php

namespace App\Console\Commands;

use App\Models\Vendor;
use App\Models\VendorCommission;
use App\Models\VendorCommissionSettlement;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SuspendOverdueVendors extends Command
{
    protected $signature = 'vendors:suspend-overdue';
    protected $description = 'Suspend vendors who have not settled COD commissions within the 7-day window';

    public function handle()
    {
        $vendors = Vendor::where('id', '!=', 1)
            ->where('status', '!=', 'suspended')
            ->whereHas('commissions', fn($q) => $q->where('payment_method', 'cod')->where('status', 'pending'))
            ->get();

        $suspendedCount = 0;

        foreach ($vendors as $vendor) {
            $lastSettlement = VendorCommissionSettlement::where('vendor_id', $vendor->id)
                ->cod()
                ->orderBy('period_end', 'desc')
                ->first();

            $oldestPending = VendorCommission::where('vendor_id', $vendor->id)
                ->where('payment_method', 'cod')
                ->where('status', 'pending')
                ->whereHas('orderItem', fn($q) => $q->where('status', '!=', 'pending'))
                ->min('created_at');

            $periodStart = $lastSettlement
                ? Carbon::parse($lastSettlement->period_end)->addDay()->startOfDay()
                : ($oldestPending ?? now());

            $deadline = Carbon::parse($periodStart)->addDays(7)->endOfDay();

            if (now()->greaterThan($deadline)) {
                $vendor->update(['status' => 'Suspended']);
                $suspendedCount++;

                // Optional: notify vendor here (email/notification)
                // $vendor->notify(new AccountSuspendedNotification());
            }
        }

        $this->info("Suspended {$suspendedCount} vendor(s) for overdue COD commission settlement.");
    }
}