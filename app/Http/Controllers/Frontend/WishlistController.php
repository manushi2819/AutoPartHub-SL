<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
   
  public function index() 
    {
        $customer = auth()->guard('customer')->user();
        $customerId = $customer ? $customer->id : null;
        $sessionId = $customerId ? null : session()->getId();

        // Fetch Wishlist items for customer or session
        $wishlistItems = Wishlist::with('product.images')
            ->where(function ($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        return view('Frontend.wishlist', compact('wishlistItems'));
    }


    /**
     * Add product to wishlist
     */
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
         
        $customer = auth()->guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        if (!$customerId) {
            // Use session ID for guest
            $sessionId = session()->getId();

            $wishlist = Wishlist::firstOrNew([
                'customer_id' => null,
                'session_id'  => $sessionId,  // <--- add this
                'product_id'  => $product->id,
            ]);

            $wishlist->save();
        } else {
            $wishlist = Wishlist::firstOrCreate([
                'customer_id' => $customerId,
                'product_id'  => $product->id,
            ]);
        }

         // ✅ Return JSON for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
        ]);
    }

}