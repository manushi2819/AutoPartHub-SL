<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Vendor;
use App\Models\ReviewImage;

class VendorReviewController extends Controller
{

    public function index()
    {
        $vendorId = session('vendor_id');

        $reviews = Review::with('product')
            ->whereHas('product', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->latest()
            ->get();

        return view('VendorDashboard.Reviews.index', compact('reviews'));
    }
    
    public function approve(Review $review)
    {
        $review->status = 'approved';
        $review->save();

        return back()->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->status = 'rejected';
        $review->save();

        return back()->with('success', 'Review rejected successfully!');
    }

    public function destroy(Review $review)
    {
        // Delete associated images
        foreach($review->images as $image){
            @unlink(public_path('uploads/'.$image->image));
            $image->delete();
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }


}