<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewImage;

class AdminReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with('product')
            ->whereHas('product', function ($query) {
                $query->where('vendor_id', 1);
            })
            ->latest()
            ->get();

        return view('AdminDashboard.Reviews.index', compact('reviews'));
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