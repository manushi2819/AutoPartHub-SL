<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Vehicle;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AuctionBid;
use App\Models\AuctionNotification;
use App\Mail\AuctionEndedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\AuctionWinner;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{



    public function statusCheck()
    {
        $this->updateAuctionStatuses(); 
        $now = now();
        $hasChange = Auction::where(function ($q) use ($now) {
            $q->where('end_time', '<=', $now)
            ->where('status', '!=', 'ended');
        })->exists();

        return response()->json([
            'refresh' => $hasChange
        ]);
    }



   private function updateAuctionStatuses()
    {
        $now = now();

        // ACTIVE
        $activeUpdated = Auction::where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->update(['status' => 'active']);

        // ENDED
        $endedAuctions = Auction::where('end_time', '<=', $now)
            ->where('status', '!=', 'ended')
            ->get();

        foreach ($endedAuctions as $auction) {

            try {

                $auction->update(['status' => 'ended']);

                // ===== WINNER =====
                $highestBid = AuctionBid::where('auction_id', $auction->id)
                    ->orderByDesc('bid_amount')
                    ->first();

                if ($highestBid) {

                    Log::info("Highest bid found", [
                        'auction_id' => $auction->id,
                        'bid_id' => $highestBid->id,
                        'amount' => $highestBid->bid_amount
                    ]);

                    $exists = AuctionWinner::where('auction_id', $auction->id)->exists();

                    if (!$exists) {

                        AuctionWinner::create([
                            'auction_id' => $auction->id,
                            'winner_id' => $highestBid->customer_id,
                            'winner_bid_id' => $highestBid->id,
                            'winner_price' => $highestBid->bid_amount,
                            'status' => 'pending_admin_approval',
                        ]);

                        $highestBid->update([
                            'is_winner' => 1
                        ]);

                        Log::info("Winner created", ['auction_id' => $auction->id]);
                    }
                }

                // ===== EMAILS =====
                $customerIds = AuctionBid::where('auction_id', $auction->id)
                    ->whereNotNull('customer_id')
                    ->distinct()
                    ->pluck('customer_id');

                Log::info("Customers found", [
                    'auction_id' => $auction->id,
                    'count' => $customerIds->count()
                ]);

                foreach ($customerIds as $customerId) {

                    $exists = AuctionNotification::where([
                        'auction_id' => $auction->id,
                        'customer_id' => $customerId,
                        'type' => 'auction_ended'
                    ])->exists();

                    if ($exists) {
                        Log::info("Email already sent, skipping", [
                            'auction_id' => $auction->id,
                            'customer_id' => $customerId
                        ]);
                        continue;
                    }

                    $customer = Customer::find($customerId);

                    if (!$customer) {
                        Log::warning("Customer not found", ['customer_id' => $customerId]);
                        continue;
                    }

                    Mail::to($customer->email)
                        ->send(new AuctionEndedMail($auction));

                    AuctionNotification::create([
                        'auction_id' => $auction->id,
                        'customer_id' => $customerId,
                        'type' => 'auction_ended',
                        'sent_at' => now(),
                    ]);
                }

            } catch (\Exception $e) {

                Log::error("Auction processing failed", [
                    'auction_id' => $auction->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // UPCOMING
        $upcomingUpdated = Auction::where('start_time', '>', $now)
            ->update(['status' => 'upcoming']);
    }


    //  INDEX
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        $now = now();

        $auctions = Auction::with(['highestBid', 'vehicle', 'product'])
            ->when($status === 'active', function ($q) use ($now) {
                $q->where('start_time', '<=', $now)
                ->where('end_time', '>', $now);
            })
            ->when($status === 'ended', function ($q) use ($now) {
                $q->where('end_time', '<=', $now);
            })
            ->when($status === 'upcoming', function ($q) use ($now) {
                $q->where('start_time', '>', $now);
            })
            ->latest()
            ->get();

        return view('AdminDashboard.Auctions.index', compact('auctions', 'status'));
    }


    // CREATE
    public function create()
    {
        $vehicles = Vehicle::with(['brand', 'images'])
            ->get(['id', 'brand_id', 'model', 'year', 'price']);

        $products = Product::with(['brand', 'images'])
            ->select('id', 'name', 'sku', 'brand_id', 'price')
            ->get();

        return view('AdminDashboard.Auctions.create', compact('vehicles', 'products'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required',
            'item_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'starting_price' => 'required|numeric',
            'bid_increment' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        Auction::create([
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'starting_price' => $request->starting_price,
            'bid_increment' => $request->bid_increment,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.auctions.index')->with('success', 'Auction Created');
    }

    // EDIT
    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        $vehicles = Vehicle::with(['brand', 'images'])
            ->get(['id', 'brand_id', 'model', 'year', 'price']);

        $products = Product::with(['brand', 'images'])
            ->select('id', 'name', 'sku', 'brand_id', 'price')
            ->get();

        return view('AdminDashboard.Auctions.edit', compact('auction', 'vehicles', 'products'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        $auction->update([
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'starting_price' => $request->starting_price,
            'bid_increment' => $request->bid_increment,
            'is_active' => $request->is_active,
        ]);

        $now = now();
        if ($request->end_time <= $now) {
            $status = 'ended';
        } elseif ($request->start_time <= $now) {
            $status = 'active';
        } else {
            $status = 'upcoming';
        }

        $auction->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $status,
        ]);

        return redirect()->route('admin.auctions.index')->with('success', 'Auction Updated');
    }


    //delete
    public function destroy(Auction $auction)
    {
        $auction->delete();
        return redirect()->route('admin.auctions.index')->with('success', 'Auction Deleted');
    }
    
}