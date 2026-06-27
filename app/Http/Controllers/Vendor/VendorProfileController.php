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

        $section = $request->input('section', 'profile');

        if ($section === 'bank') {
            $request->validate([
                'bank_name' => 'nullable|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'account_name' => 'nullable|string|max:255',
                'account_number' => 'nullable|string|max:255',
            ]);

            $data = $request->only([
                'bank_name',
                'branch_name',
                'account_name',
                'account_number',
            ]);
        } else {
            $request->validate([
                'shop_name' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'email' => 'required|email|unique:vendors,email,' . $vendor->id,
                'phone' => 'required|string|max:50',
                'nic' => 'required|string|unique:vendors,nic,' . $vendor->id,
                'business_registration' => 'nullable|string|max:255',
                'found_year' => 'nullable|integer|min:1900|max:2100',
                'description' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
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
                'business_registration',
                'found_year',
                'description',
                'bank_name',
                'branch_name',
                'account_name',
                'account_number',
            ]);
        }

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
