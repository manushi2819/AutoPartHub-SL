<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Order;

class CustomerProfileController extends Controller
{
    

    public function index(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        $orders = $customer->orders()->with('items.product')->orderBy('created_at', 'desc')->get();

        return view('CustomerDashboard.account', compact('customer', 'orders'));
    }


    public function profile()
    {
        $customer = auth('customer')->user();
        return view('CustomerDashboard.profile', compact('customer'));
    }

    public function orders()
    {
        $customer = auth('customer')->user();

        $orders = $customer->orders()
            ->with('items.product')
            ->latest()
            ->paginate(5); 
        return view('CustomerDashboard.orders', compact('orders', 'customer'));
    }

    public function password()
    {
        $customer = auth('customer')->user();
        return view('CustomerDashboard.password', compact('customer'));
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


    public function track($id)
    {
        $order = Order::with('items.product')->where('id', $id)
                    ->where('customer_id', auth()->guard('customer')->id())
                    ->firstOrFail();

        return view('CustomerDashboard.track_order', compact('order'));
    }


    public function updateDeliveredStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
                    ->where('customer_id', auth()->guard('customer')->id())
                    ->firstOrFail();

        if($order->status !== 'delivered') {
            $order->status = 'delivered';
            $order->save();
        }

        return redirect()->back()->with('success', 'Order marked as delivered.');
    }

}