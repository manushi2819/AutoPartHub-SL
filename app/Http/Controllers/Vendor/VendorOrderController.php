<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderInTransitMail;
use App\Mail\OrderConfirmedMail;
use Illuminate\Support\Facades\Mail;

class VendorOrderController extends Controller
{
   
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
            // now filtering on the vendor's own items' payment status
            $query->whereHas('items', function ($q) use ($request, $vendorId) {
                $q->where('vendor_id', $vendorId)
                  ->where('payment_status', $request->payment_status);
            });
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


  
    public function show($id)
    {
        $vendorId = session('vendor_id');

        $order = Order::with(['customer', 'items' => function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            }, 'items.product'])
            ->findOrFail($id);

        // Guard: if somehow this vendor has no items on this order, don't show it at all
        if ($order->items->isEmpty()) {
            abort(404);
        }

        return view('VendorDashboard.Orders.show', compact('order'));
    }

    
    public function updateItemStatus(Request $request, $itemId)
    {
        $request->validate([
            'status'         => 'nullable|in:pending,confirmed,in_transit,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid',
            'tracking_no'    => 'nullable|string|max:255',
        ]);

        $vendorId = session('vendor_id');

        $item = OrderItem::with(['order', 'product'])->findOrFail($itemId);

        if ($item->vendor_id != $vendorId) {
            abort(403, 'You are not authorized to update this item.');
        }

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

        if ($request->filled('payment_status')) {
            $item->payment_status = $request->payment_status;
        }

        if ($request->filled('tracking_no')) {
            $item->tracking_no = $request->tracking_no;
        }

        $item->save();

        // ✅ Email now carries only the item(s) that changed, not the full order
        if ($statusChangedToConfirmed) {
            Mail::to($order->email)->send(new OrderConfirmedMail($order, $item));
        }

        if ($statusChangedToInTransit) {
            Mail::to($order->email)->send(new OrderInTransitMail($order, $item));
        }
        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}