<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionBidController extends Controller
{
    
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');
        $auctionId = $request->get('auction_id');

        $query = Auction::with([
                'bids.customer',
                'highestBid',
                'vehicle.brand',
                'product'
            ])
            ->where('is_active', 1);

        // STATUS FILTER
        $query->whereRaw("
            CASE
                WHEN end_time <= NOW() THEN 'ended'
                WHEN start_time <= NOW() THEN 'active'
                ELSE 'upcoming'
            END = ?
        ", [$status]);

        // DEFAULT: latest auction auto-selected
        if (!$auctionId) {
            $latestAuction = (clone $query)->latest()->first();
            $auctionId = $latestAuction?->id;
        }

        // FILTER BY SELECTED AUCTION
        if ($auctionId) {
            $query->where('id', $auctionId);
        }

        $auctions = $query->latest()->get();

        // DROPDOWN (same status only)
        $allAuctions = Auction::with(['vehicle', 'product'])
            ->where('is_active', 1)
            ->whereRaw("
                CASE
                    WHEN end_time <= NOW() THEN 'ended'
                    WHEN start_time <= NOW() THEN 'active'
                    ELSE 'upcoming'
                END = ?
            ", [$status])
            ->select('id', 'item_type', 'item_id', 'start_time', 'end_time')
            ->latest()
            ->get();

        return view('AdminDashboard.Auctions.bids', compact(
            'auctions',
            'status',
            'auctionId',
            'allAuctions'
        ));
    }


    public function bidCount($id)
    {
        $auction = \App\Models\Auction::findOrFail($id);
        return response()->json([
            'count' => $auction->bids()->count()
        ]);
    }


}