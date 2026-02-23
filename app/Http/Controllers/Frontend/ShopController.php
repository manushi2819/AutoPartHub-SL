<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVehicleCompatibility;

class ShopController extends Controller
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

        $brands = ProductVehicleCompatibility::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

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
            $q->orWhereHas('compatibility', function($q2) use ($request){
                $q2->where('year_from', '<=', $request->year)
                   ->where('year_to', '>=', $request->year);
            });
        });

        $products->when($request->filled('brand'), function($q) use ($request) {
            $q->orWhereHas('compatibility', fn($q2)=> $q2->where('brand', $request->brand));
        });

        $products->when($request->filled('model'), function($q) use ($request) {
            $q->orWhereHas('compatibility', fn($q2)=> $q2->where('model', $request->model));
        });

        $products->when($request->filled('engine_cc'), function($q) use ($request) {
            $q->orWhereHas('compatibility', fn($q2)=> $q2->where('engine_cc', $request->engine_cc));
        });

        $products->when($request->filled('fuel_type'), function($q) use ($request) {
            $q->orWhereHas('compatibility', fn($q2)=> $q2->where('fuel_type', $request->fuel_type));
        });

        $products->when($request->filled('engine_type'), function($q) use ($request) {
            $q->orWhereHas('compatibility', fn($q2)=> $q2->where('engine_type', $request->engine_type));
        });

        // -------------------------
        // Price Filter
        // -------------------------
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // -------------------------
        // Category Filter (include parent/child)
        // -------------------------
        if ($request->filled('category')) {
            $products->whereIn('category_id', function($query) use ($request) {
                $query->select('id')
                      ->from('categories')
                      ->whereIn('id', $request->category)
                      ->orWhereIn('parent_id', $request->category);
            });
        }

        // -------------------------
        // Pagination
        // -------------------------
        $products = $products->paginate(12)->withQueryString();

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