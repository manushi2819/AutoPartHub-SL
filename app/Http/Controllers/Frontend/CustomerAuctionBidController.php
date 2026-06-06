<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\AuctionWinner;
use App\Models\Product;
use App\Models\CustomerActivity;
use App\Models\Brand;
use App\Models\Vehicle;

class CustomerAuctionBidController extends Controller
{
    public function index()
    {
        $customer = auth()->guard('customer')->user();
        $recommendedProducts = $this->getRecommendedProducts($customer->id);
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
            'auctions',
            'recommendedProducts'
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



 private function getRecommendedProducts($customerId)
{
    $activities = CustomerActivity::where('customer_id', $customerId)
        ->latest()
        ->get();

    $brandScores = [];
    $categoryScores = [];
    $modelScores = [];

    foreach ($activities as $activity) {

        switch ($activity->activity_type) {

            // =========================
            // PRODUCT VIEW
            // =========================
            case 'product_view':

                $product = Product::find($activity->reference_id);

                if ($product) {

                    if ($product->brand_id) {
                        $brandScores[$product->brand_id] =
                            ($brandScores[$product->brand_id] ?? 0) + 2;
                    }

                    if ($product->category_id) {
                        $categoryScores[$product->category_id] =
                            ($categoryScores[$product->category_id] ?? 0) + 2;
                    }
                }

                break;

            // =========================
            // CATEGORY VIEW
            // =========================
            case 'category_view':

                if ($activity->reference_id) {
                    $categoryScores[$activity->reference_id] =
                        ($categoryScores[$activity->reference_id] ?? 0) + 3;
                }

                break;

            // =========================
            // BRAND VIEW
            // =========================
            case 'brand_view':

                $brandId = Brand::where('name', $activity->value)->value('id');

                if ($brandId) {
                    $brandScores[$brandId] =
                        ($brandScores[$brandId] ?? 0) + 3;
                }

                break;

            // =========================
            // VEHICLE VIEW (HIGHEST PRIORITY)
            // =========================
            case 'vehicle_view':

                $vehicle = Vehicle::find($activity->reference_id);

                if ($vehicle) {

                    // Vehicle brand
                    if ($vehicle->brand) {
                        $brandScores[$vehicle->brand->id] =
                            ($brandScores[$vehicle->brand->id] ?? 0) + 5;
                    }

                    // Vehicle model
                    if ($vehicle->model) {
                        $modelScores[$vehicle->model] =
                            ($modelScores[$vehicle->model] ?? 0) + 5;
                    }
                }

                break;

            // =========================
            // VEHICLE BRAND SEARCH
            // =========================
            case 'vehicle_brand_view':

                $brandId = Brand::where('name', $activity->value)->value('id');

                if ($brandId) {
                    $brandScores[$brandId] =
                        ($brandScores[$brandId] ?? 0) + 4;
                }

                break;

            // =========================
            // VEHICLE SEARCH (MODEL)
            // =========================
            case 'vehicle_search':

                $modelScores[$activity->value] =
                    ($modelScores[$activity->value] ?? 0) + 4;

                break;
        }
    }

    // =========================
    // SORT SCORES
    // =========================
    arsort($brandScores);
    arsort($categoryScores);
    arsort($modelScores);

    $topBrandIds = array_slice(array_keys($brandScores), 0, 3);
    $topCategoryIds = array_slice(array_keys($categoryScores), 0, 5);
    $topModels = array_slice(array_keys($modelScores), 0, 5);

    // =========================
    // BUILD RECOMMENDATIONS
    // =========================
    return Product::with(['images', 'category', 'brand'])
        ->withCount('reviews')
        ->withAvg('reviews', 'rating')
        ->where('status', 1)
        ->where(function ($q) use ($topBrandIds, $topCategoryIds, $topModels) {

            // Brand match
            if (!empty($topBrandIds)) {
                $q->orWhereIn('brand_id', $topBrandIds);
            }

            // Category match
            if (!empty($topCategoryIds)) {
                $q->orWhereIn('category_id', $topCategoryIds);
            }

            // Vehicle compatibility match (VERY IMPORTANT)
            if (!empty($topModels)) {
                $q->orWhereHas('compatibility', function ($c) use ($topModels) {
                    $c->whereIn('model', $topModels);
                });
            }
        })
        ->latest()
        ->take(8)
        ->get();
}

}