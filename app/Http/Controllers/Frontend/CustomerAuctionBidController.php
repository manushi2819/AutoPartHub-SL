<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\AuctionWinner;

class CustomerAuctionBidController extends Controller
{
    public function index()
    {
        $customer = auth()->guard('customer')->user();

        $auctions = Auction::with([
                'vehicle.brand',
                'vehicle.images',
                'product.brand',
                'product.images',
                'highestBid.customer'
            ])
            ->whereHas('bids', function ($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            })
            ->latest()
            ->paginate(5);

        return view('CustomerDashboard.auction-bids', compact(
            'customer',
            'auctions'
        ));
    }

    public function show($id)
    {
        $customer = auth()->guard('customer')->user();

        $auction = Auction::with([
                'vehicle.brand',
                'vehicle.images',
                'product.brand',
                'product.images',
                'bids.customer',
                'highestBid.customer'
            ])
            ->findOrFail($id);

        $customerParticipated = $auction->bids()
            ->where('customer_id', $customer->id)
            ->exists();

        $bids = $auction->bids()
            ->with('customer')
            ->latest('bid_amount')
            ->paginate(12);

        $customerHighestBid = $auction->bids()
            ->where('customer_id', $customer->id)
            ->max('bid_amount');

        return view('CustomerDashboard.auction-bid-details', compact(
            'auction',
            'bids',
            'customerHighestBid',
            'customer'
        ));
    }
}