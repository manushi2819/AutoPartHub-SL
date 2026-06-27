<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorRegistrationMail;
use App\Mail\AdminNewVendorMail;

class FrontendVendorController extends Controller
{
    public function index()
    {
        return view('Frontend.vendor.become_vendor');
    }


    public function showRegister()
    {
        return view('Frontend.vendor.register');
    }


    public function register(Request $request)
    {
        $request->validate([
            'shop_name' => 'required',
            'owner_name' => 'required',
            'email' => 'required|email|unique:vendors',
            'phone' => 'required',
            'nic' => 'required|unique:vendors',
            'password' => 'required|min:6|confirmed'
        ]);

        $plainPassword = $request->password;

        $vendor = Vendor::create([
            'shop_name' => $request->shop_name,
            'slug' => Str::slug($request->shop_name . '-' . time()),
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nic' => $request->nic,
            'address' => $request->address ?? '',
            'district' => $request->district ?? '',
            'province' => $request->province ?? '',
            'bank_name' => $request->bank_name ?? '',
            'branch_name' => $request->branch_name ?? '',
            'account_name' => $request->account_name ?? '',
            'account_number' => $request->account_number ?? '',
            'nic_front' => $request->nic_front ?? '',
            'nic_back' => $request->nic_back ?? '',
            'business_registration' => $request->business_registration ?? null,
            'password' => Hash::make($request->password),
            'status' => 'Pending'
        ]);

        try {
            Mail::to($vendor->email)
                ->send(new VendorRegistrationMail($vendor, $plainPassword));

            Mail::to('kasthurid1234@gmail.com')
                ->send(new AdminNewVendorMail($vendor));
        } catch (\Exception $e) {
            // Fail silently for now; registration still completes.
        }

        return redirect()->route('vendor.login')
            ->with('success', 'Vendor registration successful. Your account is awaiting admin approval.');
    }

    public function showLogin()
    {
        return view('Frontend.vendor.login');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $vendor = Vendor::where('email', $request->email)->first();

        if (! $vendor || ! Hash::check($request->password, $vendor->password)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $status = strtolower($vendor->status);

        // ONLY APPROVED CAN LOGIN
        if ($status !== 'approved') {

            if ($status === 'pending') {
                return back()->with('warning', 'Your account is awaiting admin approval.');
            }

            if ($status === 'rejected') {
                return back()->with('error', 'Your application has been rejected.');
            }

            if ($status === 'suspended') {
                return back()->with('error', 'Your account has been suspended.');
            }

            return back()->withErrors(['email' => 'Account not active.']);
        }

        // LOGIN SESSION
        session([
            'vendor_id' => $vendor->id,
            'vendor_name' => $vendor->shop_name
        ]);

        return redirect()->route('vendor.dashboard');
    }



    public function logout()
    {
        session()->forget(['vendor_id', 'vendor_name']);
        return redirect()->route('vendor.login');
    }


  
    public function shops()
    {
        $vendors = Vendor::withCount('products')
            ->where('status', 'Approved')
            ->orderBy('shop_name')
            ->get();

        return view('Frontend.vendor.shops', compact('vendors'));
    }


}