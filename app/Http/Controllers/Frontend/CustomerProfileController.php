<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerProfileController extends Controller
{
    

    public function index(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        return view('Frontend.account', compact('customer'));
    }


    public function update(Request $request)
    {
        $customer = auth()->guard('customer')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:1000',
        ]);

        $customer->update($request->only('first_name', 'last_name', 'email', 'phone', 'address'));

        return back()->with('success', 'Profile updated successfully!');
    }

    
    // Update password
    public function updatePassword(Request $request)
    {
        $customer = auth()->guard('customer')->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        return back()->with('success', 'Password updated successfully!');
    }
}