<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVehicleCompatibility;
use App\Models\CustomerActivity;

class PartDetailsController extends Controller
{

    public function index($id)
    {
        $product = Product::with(['images', 'category', 'compatibility', 'reviews.images'])->findOrFail($id);

        $brand = $product->brand;
        $model = $product->compatibility->model ?? '';

        $relatedProducts = collect();

        // ✅ 1️⃣ Get all category tree IDs (parent, sub, sub-sub, siblings)
        $categoryIds = Category::getCategoryTreeIds($product->category_id);

        // 2️⃣ Get products in the same category tree
        $categoryProducts = Product::with(['images', 'compatibility'])
            ->where('id', '!=', $product->id)
            ->whereIn('category_id', $categoryIds)
            ->take(10)
            ->get();

        $relatedProducts = $relatedProducts->merge($categoryProducts);

        // 3️⃣ Fill with same brand if less than 10
        if ($relatedProducts->count() < 10 && $brand) {
            $brandProducts = Product::with(['images', 'compatibility'])
                ->where('id', '!=', $product->id)
                ->where('brand', $brand)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->take(10 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($brandProducts);
        }

        // 4️⃣ Fill with same model if still less than 10
        if ($relatedProducts->count() < 10 && $model) {
            $modelProducts = Product::with(['images', 'compatibility'])
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->whereHas('compatibility', function ($q) use ($model) {
                    $q->where('model', $model);
                })
                ->take(10 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($modelProducts);
        }

        // Limit to 10
        $relatedProducts = $relatedProducts->take(10);

        if(auth('customer')->check())
        {
            CustomerActivity::create([
                'customer_id' => auth('customer')->id(),
                'activity_type' => 'product_view',
                'reference_id' => $product->id
            ]);
        }

        return view('Frontend.part-details', compact('product', 'relatedProducts'));
    }

}