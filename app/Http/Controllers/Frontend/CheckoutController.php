<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        // Use session_id for guest
        $sessionId = $customerId ? null : session()->getId();

        // Get cart items
        $cartQuery = Cart::with('product');

        if ($customerId) {
            $cartQuery->where('customer_id', $customerId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }

        $cartItems = $cartQuery->get();

        // Calculate subtotal and total
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $total = $subtotal; 

        return view('Frontend.checkout', [
            'customer' => $customer,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }



    public function placeOrder(Request $request)
    {
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
            'city'=>'required',
            'zip'=>'required',
            'payment_method'=>'required',
        ]);

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;
        $sessionId = $customerId ? null : session()->getId();

        $cartItems = Cart::with('product')
            ->when($customerId, fn($q) => $q->where('customer_id', $customerId))
            ->when(!$customerId, fn($q) => $q->where('session_id', $sessionId))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        $discount = 0;
        $total = $subtotal - $discount;

        // Create Order
        $order = Order::create([
            'customer_id' => $customerId,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => 'Sri Lanka',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
        ]);

        // Create Order Items & Reduce stock
        foreach($cartItems as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
            ]);

            // Reduce stock
            if ($item->product) {
                $item->product->decrement('stock_quantity', $item->quantity);
            }
        }

        // Clear cart
        if ($customerId) {
            Cart::where('customer_id', $customerId)->delete();
        } else {
            Cart::where('session_id', $sessionId)->delete();
        }

        // Send Emails
        Mail::to($order->email)->send(new OrderPlaced($order));
        Mail::to('kasthurid1234@gmail.com')->send(new OrderPlaced($order, true));

        return redirect()->route('Frontend.checkout.success', ['order_id'=>$order->id]);
    }


    public function success($order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);

        return view('Frontend.checkout_success', compact('order'));
    }
}