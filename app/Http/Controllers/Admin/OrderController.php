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
    // INDEX — only orders that contain at least one item belonging to this vendor
    public function index(Request $request)
    {
        $vendorId = session('vendor_id');

        $query = Order::with(['customer', 'items' => function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            }])
            ->whereHas('items', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('customer_name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->customer_name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->customer_name . '%');
            });
        }

        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $orders = $query->get();

        return view('VendorDashboard.Orders.index', compact('orders'));
    }

    // SHOW — display all items, but flag which ones this vendor can edit
    public function show($id)
    {
        $vendorId = session('vendor_id');

        $order = Order::with('customer', 'items.product')->findOrFail($id);

        $order->items->each(function ($item) use ($vendorId) {
            $item->is_editable = $item->vendor_id == $vendorId;
        });

        return view('AdminDashboard.Orders.show', compact('order'));
    }

    // Update a single order item's status — vendor can only touch their own items
    public function updateItemStatus(Request $request, $itemId)
    {
        $request->validate([
            'status'      => 'nullable|in:pending,confirmed,in_transit,delivered,cancelled',
            'tracking_no' => 'nullable|string|max:255',
        ]);

        $vendorId = session('vendor_id');

        $item = OrderItem::with('order')->findOrFail($itemId);

        $order = $item->order;

        $statusChangedToInTransit = false;
        $statusChangedToConfirmed = false;

        if ($request->filled('status')) {
            if ($request->status === 'in_transit' && $item->status !== 'in_transit') {
                $statusChangedToInTransit = true;
            }

            if ($request->status === 'confirmed' && $item->status !== 'confirmed') {
                $statusChangedToConfirmed = true;
            }

            $item->status = $request->status;
        }

        if ($request->filled('tracking_no')) {
            $item->tracking_no = $request->tracking_no;
        }

        $item->save();

        if ($statusChangedToConfirmed) {
            Mail::to($order->email)->send(new OrderConfirmedMail($order));
        }

        if ($statusChangedToInTransit) {
            Mail::to($order->email)->send(new OrderInTransitMail($order));
        }

        return redirect()->back()->with('success', 'Item status updated successfully.');
    }

    // Payment status still lives on the Order — keep this admin-only, separate from vendor item updates
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid',
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}