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
use Illuminate\Support\Facades\Http;


class BuynowCheckoutController extends Controller
{
   
    public function buyNow($productId, $quantity = 1)
    {
        $product = Product::with('images')->findOrFail($productId);

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
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
            'city'=>'required',
            'zip'=>'required',
            'payment_method'=>'required',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1',
        ]);

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $subtotal = $product->price * $quantity;
        $discount = 0;
        $total = $subtotal - $discount;

        // Create order with pending status
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
            'payment_status' => 'pending',
        ]);

        // Create order item and reduce stock
        OrderItem::create(array_merge([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
            'subtotal' => $subtotal,
            'status' => 'pending',
            'payment_status' => 'pending',
        ], $this->buildVendorItemData($product, $quantity, $subtotal)));
        $product->decrement('stock_quantity', $quantity);

        // Send emails for COD only
        if ($request->payment_method === 'cod') {
            Mail::to($order->email)->send(new OrderPlaced($order));
            Mail::to('kasthurid1234@gmail.com')->send(new OrderPlaced($order, true));
        }

        // Redirect to CyberSource if card payment
        if ($request->payment_method === 'card') {
            return $this->redirectToCyberSource($order);
        }

        // For COD, redirect directly
        return redirect()->route('Frontend.checkout.cod_success', ['order_id'=>$order->id]);
    }



    private function buildVendorItemData(Product $product, int $quantity, float $subtotal): array
    {
        $percentage = (float) ($product->vendor_percentage ?? 0);
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

        // Required fields
        $uuid = Str::uuid();
        $signedDateTime = gmdate("Y-m-d\TH:i:s\Z");
        $referenceNumber = $order->order_number;

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
            "reference_number" => $referenceNumber,
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
            "merchant_defined_data1" => $order->id, // pass order id to track in return
        ];

        // Generate signature
        $dataToSign = collect(explode(',', $fields['signed_field_names']))
            ->map(fn($key) => "$key={$fields[$key]}")
            ->implode(',');

        $fields['signature'] = base64_encode(hash_hmac('sha256', $dataToSign, $secretKey, true));

        // Return Blade view that auto-submits
        return view('Frontend.cybersource_redirect', ['fields' => $fields, 'cybsUrl' => $cybsUrl]);
    }




}