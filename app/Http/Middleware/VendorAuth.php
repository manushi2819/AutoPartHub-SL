<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('vendor_id')) {
            return redirect()->route('vendor.login');
        }

        return $next($request);
    }
}