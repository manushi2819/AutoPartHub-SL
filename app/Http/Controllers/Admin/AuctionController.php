<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Vehicle;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuctionController extends Controller
{
    // AUTO STATUS UPDATE
    private function updateAuctionStatuses()
    {
        $now = now();

        // Set active auctions
        Auction::where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->where('status', '!=', 'active') // only update if not already active
            ->update(['status' => 'active']);

        // Set ended auctions
        Auction::where('end_time', '<=', $now)
            ->where('status', '!=', 'ended') // only update if not already ended
            ->update(['status' => 'ended']);

        // Set upcoming auctions
        Auction::where('start_time', '>', $now)
            ->where('status', '!=', 'upcoming')
            ->update(['status' => 'upcoming']);
    }

    //  INDEX
    public function index()
    {
        // Update statuses before fetching
        $this->updateAuctionStatuses();

        $active = Auction::where('status', 'active')->latest()->get();
        $upcoming = Auction::where('status', 'upcoming')->latest()->get();
        $ended = Auction::where('status', 'ended')->latest()->get();

        return view('AdminDashboard.Auctions.index', compact('active', 'upcoming', 'ended'));
    }

    // CREATE
    public function create()
    {
        $vehicles = Vehicle::with('brand')->get(['id', 'brand_id', 'model', 'year','price']);
        $products = Product::select('id', 'name','sku','brand','price')->get();

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
            'status' => now()->lt($request->start_time) ? 'upcoming' : 'active',
        ]);

        return redirect()->route('admin.auctions.index')->with('success', 'Auction Created');
    }

    // EDIT
    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        $vehicles = Vehicle::with('brand')->get(['id', 'brand_id', 'model', 'year','price']);
        $products = Product::select('id', 'name','sku','brand','price')->get();

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

        return redirect()->route('admin.auctions.index')->with('success', 'Auction Updated');
    }


    //delete
    public function destroy(Auction $auction)
    {
        $auction->delete();
        return redirect()->route('admin.auctions.index')->with('success', 'Auction Deleted');
    }
    
}