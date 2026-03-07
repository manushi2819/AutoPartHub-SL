<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVehicleCompatibility;
use App\Models\CustomerActivity;

class PartShopController extends Controller
{
    public function index(Request $request)
    {
        // -------------------------
        // Get unique dropdown values
        // -------------------------
        $years = ProductVehicleCompatibility::select('year_from')
            ->distinct()
            ->orderBy('year_from', 'desc')
            ->pluck('year_from');

        $brands = Brand::where('status', 1)->get();

        $models = ProductVehicleCompatibility::select('model')
            ->distinct()
            ->orderBy('model')
            ->pluck('model');

        $engines = ProductVehicleCompatibility::select('engine_cc')
            ->distinct()
            ->orderBy('engine_cc')
            ->pluck('engine_cc');

        $fuelTypes = ProductVehicleCompatibility::select('fuel_type')
            ->distinct()
            ->pluck('fuel_type');

        $engineTypes = ProductVehicleCompatibility::select('engine_type')
            ->distinct()
            ->pluck('engine_type');

        // -------------------------
        // Base Product Query
        // -------------------------
        $products = Product::with(['images', 'compatibility', 'category'])
            ->where('status', 1);

        // -------------------------
        // Vehicle Filters (OR)
        // -------------------------
        $products->when($request->filled('year'), function($q) use ($request) {
            $q->whereHas('compatibility', function($q2) use ($request){
                $q2->where('year_from', '<=', $request->year)
                ->where('year_to', '>=', $request->year);
            });
        });

        $products->when($request->filled('brand'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('brand', $request->brand));
        });

        $products->when($request->filled('model'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('model', $request->model));
        });

        $products->when($request->filled('engine_cc'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('engine_cc', $request->engine_cc));
        });

        $products->when($request->filled('fuel_type'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('fuel_type', $request->fuel_type));
        });

        $products->when($request->filled('engine_type'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('engine_type', $request->engine_type));
        });

        // -------------------------
        // Category Filter
        // -------------------------
        if ($request->filled('category')) {
            $selected = array_filter((array) $request->category); // remove empty values
            if (!empty($selected)) {
                $categoryIds = \App\Models\Category::getAllDescendantIds($selected);
                $products->whereIn('category_id', $categoryIds);
            }
        }

        // -------------------------
        // Price Filter
        // -------------------------
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // -------------------------
        // Search Filter
        // -------------------------
        if ($request->filled('search')) {
            $search = $request->search;
            $products->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // -------------------------
        // Track Customer Activity
        // -------------------------
        if(auth('customer')->check())
        {
            // Search tracking
            if($request->filled('search')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'search',
                    'value' => $request->search
                ]);
            }

            // Category tracking
            if($request->filled('category')){
                foreach((array)$request->category as $cat){
                    if($cat){
                        CustomerActivity::create([
                            'customer_id' => auth('customer')->id(),
                            'activity_type' => 'category_view',
                            'reference_id' => $cat
                        ]);
                    }
                }
            }

            // Brand tracking
            if($request->filled('brand')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'brand_view',
                    'value' => $request->brand
                ]);
            }
        }

        // -------------------------
        // Pagination
        // -------------------------
       $products = $products->with(['images','category','reviews'])
            ->latest()
            ->paginate(16);

        // -------------------------
        // Categories for sidebar
        // -------------------------
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('Frontend.shop', compact(
            'products',
            'years',
            'brands',
            'models',
            'engines',
            'fuelTypes',
            'engineTypes',
            'categories'
        ));
    }





}