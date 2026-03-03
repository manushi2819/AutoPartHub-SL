<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // INDEX
    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->get();
        return view('AdminDashboard.Orders.index', compact('orders'));
    }


    public function show($id)
    {
         $order = Order::with('customer', 'items.product')->findOrFail($id);
         return view('AdminDashboard.Orders.show', compact('order'));
    }


}
