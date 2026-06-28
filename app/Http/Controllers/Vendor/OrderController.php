<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderInTransitMail;
use App\Mail\OrderConfirmedMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
   // INDEX
    public function index(Request $request)
    {
        $vendorId = session('vendor_id'); // or use 1 for testing

        $query = Order::with('customer')
            ->whereHas('orderItems', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->orderBy('created_at', 'desc');

        // Filter by Payment Status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by Payment Method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by Customer Name
        if ($request->filled('customer_name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->customer_name . '%')
                ->orWhere('last_name', 'like', '%' . $request->customer_name . '%');
            });
        }

        // Filter by Order Number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $orders = $query->get();

        return view('VendorDashboard.Orders.index', compact('orders'));
    }

    
    public function show($id)
    {
         $order = Order::with('customer', 'items.product')->findOrFail($id);
         return view('AdminDashboard.Orders.show', compact('order'));
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable|in:pending,confirmed,in_transit,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid',
            'tracking_no' => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);

        $statusChangedToInTransit = false;
        $statusChangedToConfirmed = false;

        if ($request->filled('status')) {

            if ($request->status === 'in_transit' && $order->status !== 'in_transit') {
                $statusChangedToInTransit = true;
            }

            if ($request->status === 'confirmed' && $order->status !== 'confirmed') {
                $statusChangedToConfirmed = true;
            }

            $order->status = $request->status;
        }

        if ($request->filled('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        if ($request->filled('tracking_no')) {
            $order->tracking_no = $request->tracking_no;
        }

        $order->save();

        // ✅ Send emails
        if ($statusChangedToConfirmed) {
            Mail::to($order->email)->send(new OrderConfirmedMail($order));
        }

        if ($statusChangedToInTransit) {
            Mail::to($order->email)->send(new OrderInTransitMail($order));
        }

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

}
