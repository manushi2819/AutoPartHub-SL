<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewAuctionBid;

class FrontendAuctionController extends Controller
{


    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        $auctions = Auction::with(['highestBid'])
            ->where('is_active', true)
            ->whereRaw("
                CASE
                    WHEN start_time <= NOW() AND end_time > NOW() THEN 'active'
                    WHEN start_time > NOW() THEN 'upcoming'
                    ELSE 'ended'
                END = ?
            ", [$status])
            ->orderBy('start_time', 'asc')
            ->get();

        $vehicleAuctions = $auctions->where('item_type', 'vehicle');
        $partAuctions = $auctions->where('item_type', 'product');

        return view('Frontend.auction_list', compact(
            'vehicleAuctions',
            'partAuctions',
            'status'
        ));
    }
    
    public function detail($id)
    {
        $auction = Auction::with([
            'vehicle.images',
            'vehicle.brand',
            'product.images',
            'product.brand',
            'bids.customer',
            'highestBid'
        ])->findOrFail($id);

        return view('Frontend.auction_detail', compact('auction'));
    }


    public function placeBid(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        $request->validate([
            'auction_id' => 'required',
            'bid_amount' => 'required|numeric'
        ]);

        $auction = Auction::findOrFail($request->auction_id);

        $currentHighest = optional($auction->highestBid)->bid_amount ?? $auction->starting_price;

        if ($request->bid_amount <= $currentHighest) {
            return back()->with('error', 'Bid must be higher than current highest bid');
        }

        $bid = AuctionBid::create([
            'auction_id' => $auction->id,
            'customer_id' => $customerId,
            'bid_amount' => $request->bid_amount,
            'bid_time' => now(),
        ]);

        broadcast(new NewAuctionBid($bid))->toOthers();

        return back()->with('success', 'Bid placed successfully!');
    }


    public function bidCount($id)
    {
        $auction = Auction::findOrFail($id);
        return response()->json([
            'count' => $auction->bids()->count()
        ]);
    }

}