<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\CustomerActivity;
use App\Models\Brand;
use App\Models\Vehicle;

class CustomerProfileController extends Controller
{
    

    public function index(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        $orders = $customer->orders()->with('items.product')->orderBy('created_at', 'desc')->get();

        return view('CustomerDashboard.account', compact('customer', 'orders'));
    }


    public function profile()
    {
        $customer = auth('customer')->user();
        $recommendedProducts = $this->getRecommendedProducts($customer->id);

        return view('CustomerDashboard.profile', compact(
            'customer',
            'recommendedProducts'
        ));
    }


    public function orders()
    {
        $customer = auth('customer')->user();
        $orders = $customer->orders()
            ->with('items.product')
            ->latest()
            ->paginate(5);

        $recommendedProducts = $this->getRecommendedProducts($customer->id);

        return view('CustomerDashboard.orders', compact(
            'orders',
            'customer',
            'recommendedProducts'
        ));
    }


    public function password()
    {
        $customer = auth('customer')->user();
        $recommendedProducts = $this->getRecommendedProducts($customer->id);

        return view('CustomerDashboard.password', compact(
            'customer',
            'recommendedProducts'
        ));
    }


    public function update(Request $request)
    {
        $customer = auth()->guard('customer')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:1000',
        ]);

        $customer->update($request->only('first_name', 'last_name', 'email', 'phone', 'address'));
        return back()->with('success', 'Profile updated successfully!');
    }

    
    // Update password
    public function updatePassword(Request $request)
    {
        $customer = auth()->guard('customer')->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        return back()->with('success', 'Password updated successfully!');
    }


    public function track($id)
    {
        $order = Order::with('items.product')->where('id', $id)
                    ->where('customer_id', auth()->guard('customer')->id())
                    ->firstOrFail();

        return view('CustomerDashboard.track_order', compact('order'));
    }


    public function updateDeliveredStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
                    ->where('customer_id', auth()->guard('customer')->id())
                    ->firstOrFail();

        if($order->status !== 'delivered') {
            $order->status = 'delivered';
            $order->save();
        }

        return redirect()->back()->with('success', 'Order marked as delivered.');
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