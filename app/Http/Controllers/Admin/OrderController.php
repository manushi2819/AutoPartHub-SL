<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   // INDEX
    public function index(Request $request)
    {
        $query = Order::with('customer')->orderBy('created_at', 'desc');

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

        return view('AdminDashboard.Orders.index', compact('orders'));
    }

    
    public function show($id)
    {
         $order = Order::with('customer', 'items.product')->findOrFail($id);
         return view('AdminDashboard.Orders.show', compact('order'));
    }


}
