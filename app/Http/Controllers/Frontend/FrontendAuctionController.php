<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendAuctionController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all active auctions with their related items
       $auctions = Auction::with(['highestBid'])
            ->where('is_active', true)
            ->orderByRaw("CASE 
                WHEN start_time <= NOW() AND end_time > NOW() THEN 0 
                WHEN start_time > NOW() THEN 1 
                ELSE 2 
            END")
            ->orderBy('start_time', 'asc')
            ->get();
        
        // Separate by item type and status
        $vehicleAuctions = $auctions->where('item_type', 'vehicle');
        $partAuctions = $auctions->where('item_type', 'product');
        
        // Active auctions (for main display)
        $activeVehicles = $vehicleAuctions->filter(function($auction) {
            return $auction->getCurrentStatusAttribute() === 'active';
        });
        $activeParts = $partAuctions->filter(function($auction) {
            return $auction->getCurrentStatusAttribute() === 'active';
        });
        
        // Upcoming auctions (for sidebar)
        $upcomingVehicles = $vehicleAuctions->filter(function($auction) {
            return $auction->getCurrentStatusAttribute() === 'upcoming';
        });
        $upcomingParts = $partAuctions->filter(function($auction) {
            return $auction->getCurrentStatusAttribute() === 'upcoming';
        });
        
        return view('Frontend.auction_list', compact(
            'activeVehicles', 'activeParts',
            'upcomingVehicles', 'upcomingParts'
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

        AuctionBid::create([
            'auction_id' => $auction->id,
            'customer_id' => $customerId,
            'bid_amount' => $request->bid_amount,
            'bid_time' => now(),
        ]);

        return back()->with('success', 'Bid placed successfully!');
    }

}