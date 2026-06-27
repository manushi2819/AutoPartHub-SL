<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorProfileController extends Controller
{
    public function profile()
    {
        $vendor = Vendor::find(session('vendor_id'));

        if (! $vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first.');
        }

        return view('VendorDashboard.profile', compact('vendor'));
    }

    public function update(Request $request)
    {
        $vendor = Vendor::find(session('vendor_id'));

        if (! $vendor) {
            return back()->with('error', 'Vendor not found.');
        }

        $request->validate([
            'shop_name' => 'required|string',
            'owner_name' => 'required|string',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'required|string',
            'nic' => 'required|string|unique:vendors,nic,' . $vendor->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        $data = $request->only([
            'shop_name',
            'owner_name',
            'email',
            'phone',
            'nic',
            'address',
            'district',
            'province',
            'bank_name',
            'branch_name',
            'account_name',
            'account_number',
        ]);

        if ($request->hasFile('logo')) {
            $logoName = time() . '_logo.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('uploads/vendors'), $logoName);
            $data['logo'] = 'uploads/vendors/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $bannerName = time() . '_banner.' . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('uploads/vendors'), $bannerName);
            $data['banner'] = 'uploads/vendors/' . $bannerName;
        }

        $vendor->update($data);

        return back()->with('success', 'Vendor details updated successfully.');
    }

    
    public function updatePassword(Request $request)
    {
        $vendor = Vendor::find(session('vendor_id'));

        if (! $vendor) {
            return back()->with('error', 'Vendor not found.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $vendor->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
