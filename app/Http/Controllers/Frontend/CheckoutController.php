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


    public function buyNow(Request $request)
    {
        $product = Product::with('images')->findOrFail($request->product_id);

        $quantity = $request->quantity ?? 1;

        $subtotal = $product->price * $quantity;
        $total = $subtotal;

        $customer = Auth::guard('customer')->user();

        return view('Frontend.buynowcheckout', compact(
            'product',
            'quantity',
            'subtotal',
            'total',
            'customer'
        ));
    }


    public function placeOrder(Request $request)
    {
        // Validate billing details
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'payment_method' => 'required',
        ]);

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;
        $sessionId = $customerId ? null : session()->getId();

        // Get cart items
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
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending', // card will update after CyberSource callback
        ]);

        // Create Order Items & Reduce stock
        foreach($cartItems as $item){
            OrderItem::create(array_merge([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
                'status' => 'pending',
                'payment_status' => 'pending',
            ], $this->buildVendorItemData($item)));

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

        // Send emails for COD only
        if ($request->payment_method === 'cod') {
            Mail::to($order->email)->send(new OrderPlaced($order));
            Mail::to('kasthurid1234@gmail.com')->send(new OrderPlaced($order, true));
            return redirect()->route('Frontend.checkout.cod_success', ['order_id'=>$order->id]);
        }

        // If card payment, redirect to CyberSource
        if ($request->payment_method === 'card') {
            return $this->redirectToCyberSource($order);
        }
    }


    private function buildVendorItemData($item): array
    {
        $product = $item->product;
        $percentage = (float) ($product->vendor_percentage ?? 0);
        $subtotal = (float) ($item->quantity * $item->price);
        $commission = $subtotal > 0 ? round(($subtotal * $percentage) / 100, 2) : 0.0;
        $earning = round($subtotal - $commission, 2);

        return [
            'vendor_id' => $product->vendor_id ?? null,
            'vendor_percentage' => $percentage,
            'vendor_commission_amount' => $commission,
            'vendor_earning_amount' => $earning,
        ];
    }

    private function redirectToCyberSource($order)
    {
        $cybsUrl    = 'https://testsecureacceptance.cybersource.com/pay';
        $merchantId = 'test_company12_1762061686';
        $accessKey  = '1807058e145b36baa7f615d73578e6b7';
        $secretKey  = '4cef0751bbd544fab1f92f111f3db15760b9b75f4d81408ebd6c52e66c589037263a6f1f607741d49d2163158aa86c22ab245ec167c14ebb92d24541925ad51315608a2f8d8243fe8631f85ceaa3ccbd28948525e6e14a67aad4e6bc4bf60322d6e699005ab94f7a89bff19d62511c9ddf29d8d895044c02ae1392e93a18ced9';
        $profileId  = 'A6331C57-9BBB-490C-B6D2-0E32E7EDC242';
        $currency   = 'LKR';

        $uuid = Str::uuid();
        $signedDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $fields = [
            "access_key" => $accessKey,
            "profile_id" => $profileId,
            "merchant_id" => $merchantId,
            "transaction_uuid" => $uuid,
            "signed_field_names" => "access_key,profile_id,merchant_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_address_postal_code,override_custom_receipt_page,merchant_defined_data1",
            "unsigned_field_names" => "",
            "signed_date_time" => $signedDateTime,
            "locale" => "en",
            "transaction_type" => "sale",
            "reference_number" => $order->order_number,
            "amount" => number_format($order->total, 2, '.', ''),
            "currency" => $currency,
            "bill_to_forename" => $order->first_name,
            "bill_to_surname" => $order->last_name,
            "bill_to_email" => $order->email,
            "bill_to_phone" => $order->phone,
            "bill_to_address_line1" => $order->address,
            "bill_to_address_city" => $order->city,
            "bill_to_address_country" => "LK",
            "bill_to_address_postal_code" => $order->zip,
            "override_custom_receipt_page" => route('Frontend.checkout.success.post', ['order_id'=>$order->id]),
            "merchant_defined_data1" => $order->id,
        ];

        $dataToSign = collect(explode(',', $fields['signed_field_names']))
            ->map(fn($key) => "$key={$fields[$key]}")
            ->implode(',');

        $fields['signature'] = base64_encode(hash_hmac('sha256', $dataToSign, $secretKey, true));

        return view('Frontend.cybersource_redirect', ['fields' => $fields, 'cybsUrl' => $cybsUrl]);
    }


   

    public function success(Request $request, $order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);

        // Check if this is a card payment return from CyberSource
        if ($order->payment_method === 'card') {

            // CyberSource returns 'decision' and other parameters
            $decision = $request->input('decision'); // 'ACCEPT', 'REJECT', 'ERROR'

            if ($decision === 'ACCEPT') {
                $order->payment_status = 'paid';
                $order->status = 'confirmed';
                $order->save();

                $order->items()->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                ]);

                // Send emails now that payment is successful
                Mail::to($order->email)->send(new OrderPlaced($order));
                Mail::to('kasthurid1234@gmail.com')->send(new OrderPlaced($order, true));

            } else {
                // Payment failed
                $order->payment_status = 'failed';
                $order->status = 'failed';
                $order->save();

                $order->items()->update([
                    'status' => 'failed',
                    'payment_status' => 'failed',
                ]);

                return view('Frontend.checkout_failed', compact('order', 'request'));
            }
        }

        return view('Frontend.checkout_success', compact('order'));
    }



    public function codSuccess($order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);
        return view('Frontend.checkout_success', compact('order'));
    }

}