<?php

namespace App\Http\Middleware;

use App\Models\Vendor;
use Closure;
use Illuminate\Http\Request;

class CheckVendorStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('vendor_id')) {
            $vendor = Vendor::find(session('vendor_id'));

            if (!$vendor || strtolower($vendor->status) !== 'approved') {
                session()->forget(['vendor_id', 'vendor_name']);

                $message = match (strtolower($vendor->status ?? '')) {
                    'suspended' => 'Your account has been suspended due to overdue commission payments. Please contact admin to settle your dues.',
                    'rejected' => 'Your application has been rejected.',
                    'pending' => 'Your account is awaiting admin approval.',
                    default => 'Your session has ended. Please log in again.',
                };

                return redirect()->route('vendor.login')->with('error', $message);
            }
        }

        return $next($request);
    }
}