<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;

class CartController extends Controller
{

    public function index() 
    {
        $customer = auth()->guard('customer')->user();
        $customerId = $customer ? $customer->id : null;
        $sessionId = $customerId ? null : session()->getId();

        // Fetch cart items for customer or session
        $cartItems = Cart::with('product.images')
            ->where(function ($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        return view('Frontend.cart', compact('cartItems'));
    }

     /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $customer = auth()->guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        // Use session_id for guest
        $sessionId = $customerId ? null : session()->getId();

        // Check if the cart item already exists
        $cart = Cart::firstOrNew([
            'customer_id' => $customerId,
            'session_id'  => $sessionId,
            'product_id'  => $product->id,
        ]);

        $cart->quantity = $cart->exists ? $cart->quantity + $request->quantity : $request->quantity;
        $cart->price = $product->price;
        $cart->save();

        // ✅ Return JSON for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
        ]);
    }


   public function checkout() {
        return view('Frontend.checkout');
    }
   


    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($request->cart_id);

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'success' => true,
            'item_total' => $cart->price * $cart->quantity
        ]);
    }


    public function delete(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        $cart->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
