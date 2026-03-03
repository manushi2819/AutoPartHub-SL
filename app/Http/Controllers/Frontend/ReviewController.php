<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewImage;

class ReviewController extends Controller
{


    public function store(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'files.*' => 'image|mimes:jpg,jpeg,png,gif|max:5048'
        ]);

        // Create Review
        $review = Review::create([
            'product_id' => $productId,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);

        // Upload Images
        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);

                ReviewImage::create([
                    'review_id' => $review->id,
                    'image' => $filename
                ]);
            }
        }

        return back()->with('success', 'Your review has been submitted!');
    }



    //admin functions
    public function index()
    {
        $reviews = Review::with('product')->orderBy('created_at', 'desc')->get();
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