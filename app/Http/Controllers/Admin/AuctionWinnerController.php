<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuctionWinner;
use App\Models\AuctionNotification;
use App\Models\AuctionBid;
use App\Mail\AuctionWinnerMail;
use Illuminate\Support\Facades\Mail;

class AuctionWinnerController extends Controller
{
    public function index(Request $request)
    {
        $auctionId = $request->auction_id;
        $customerId = $request->customer_id;
        $status = $request->status;

        $query = AuctionWinner::with([
            'auction',
            'winner',
            'bid',
            'auction.bids.customer',
            'auction.vehicle.brand',
            'auction.product.brand'
        ]);

        if ($auctionId) {
            $query->where('auction_id', $auctionId);
        }

        if ($customerId) {
            $query->where('winner_id', $customerId);
        }

        $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });

        $winners = $query->latest()->get();

        $allAuctions = \App\Models\Auction::latest()->get();
        $allCustomers = \App\Models\Customer::latest()->get();

        return view('AdminDashboard.Auctions.winners', compact(
            'winners',
            'allAuctions',
            'allCustomers',
            'auctionId',
            'customerId',
            'status'
        ));
    }

    public function approve($id)
    {
        $winner = AuctionWinner::with([
            'winner',
            'auction'
        ])->findOrFail($id);

        // already approved
        if ($winner->status === 'approved') {
            return back()->with('error', 'Already approved');
        }

        // approve winner
        $winner->update([
            'status' => 'approved'
        ]);

        // lock auction
        $winner->auction->update([
            'winner_approved' => 1,
            'is_active' => 0,
            'status' => 'ended'
        ]);

        // prevent duplicate emails
        $alreadySent = AuctionNotification::where([
            'auction_id' => $winner->auction_id,
            'customer_id' => $winner->winner_id,
            'type' => 'winner_approved'
        ])->exists();

        if (!$alreadySent && $winner->winner?->email) {

            Mail::to($winner->winner->email)
                ->send(new AuctionWinnerMail($winner));

            AuctionNotification::create([
                'auction_id' => $winner->auction_id,
                'customer_id' => $winner->winner_id,
                'type' => 'winner_approved',
                'sent_at' => now()
            ]);
        }

        return back()->with('success', 'Winner approved successfully');
    }


    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $winner = AuctionWinner::with([
            'winner',
            'auction'
        ])->findOrFail($id);

        $winner->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        $winner->auction->update([
            'winner_approved' => 0
        ]);

        return back()->with('success', 'Winner rejected successfully');
    }

}