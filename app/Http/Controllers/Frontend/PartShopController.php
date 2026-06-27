<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\ProductVehicleCompatibility;
use App\Models\CustomerActivity;

class PartShopController extends Controller
{
    
    public function index(Request $request, ?string $vendorSlug = null)
    {
        // -------------------------
        // Get unique dropdown values
        // -------------------------
        $years = range(1980, 2026);
        rsort($years);

        $models = ProductVehicleCompatibility::select('model')
            ->whereNotNull('model')
            ->where('model', '!=', '')
            ->distinct()
            ->orderBy('model')
            ->pluck('model');

        $brands = Brand::where('status', 1)->get();
        $engines = [800, 1000, 1300, 1500, 1800, 2000, 2500, 3000];
        $fuelTypes = ['Petrol', 'Diesel', 'Hybrid', 'Electric', 'Gas'];
        $engineTypes = ['Inline', 'Boxer', 'Rotary', 'V4', 'V8', 'V6', 'W2', 'Inline 2', 'V2'];

        $vendorSlug = $request->input('vendor_slug', $vendorSlug);
        $selectedVendor = null;

        if ($vendorSlug) {
            $selectedVendor = Vendor::where('slug', $vendorSlug)
                ->where('status', 'Approved')
                ->first();
        }

        // -------------------------
        // Category filter (resolved once, reused everywhere)
        // -------------------------
        $categoryIds = [];
        if ($request->filled('category')) {
            $selected = array_filter((array) $request->category);
            if (!empty($selected)) {
                $categoryIds = Category::getAllDescendantIds($selected);
            }
        }

        // -------------------------
        // Shared filter chain — applied identically to every product query
        // -------------------------
        $applyFilters = function (Builder $query) use ($request, $selectedVendor, $categoryIds) {
            if ($selectedVendor) {
                $query->where('vendor_id', $selectedVendor->id);
            }

            $query->when($request->filled('year'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('year_from', $request->year));
            });

            $query->when($request->filled('brand'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('brand', $request->brand));
            });

            $query->when($request->filled('model'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('model', 'like', '%' . $request->model . '%'));
            });

            $query->when($request->filled('engine_cc'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('engine_cc', $request->engine_cc));
            });

            $query->when($request->filled('fuel_type'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('fuel_type', $request->fuel_type));
            });

            $query->when($request->filled('engine_type'), function ($q) use ($request) {
                $q->whereHas('compatibility', fn($q2) => $q2->where('engine_type', $request->engine_type));
            });

            $query->when($request->vehicle_type, function ($q) use ($request) {
                $value = $request->vehicle_type;
                $q->where(function ($sub) use ($value) {
                    $sub->whereJsonContains('vehicle_type_ids', (int) $value)
                        ->orWhereJsonContains('vehicle_type_ids', (string) $value);
                });
            });

            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }

            if ($request->filled('min_price') && $request->filled('max_price')) {
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            }

            $search = $request->get('query') ?? $request->get('search');
            if ($search) {
                $keywords = explode(' ', $search);
                foreach ($keywords as $word) {
                    $query->where(function ($q) use ($word) {
                        $q->where('name', 'like', "%{$word}%")
                            ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$word}%"))
                            ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$word}%"))
                            ->orWhere('description', 'like', "%{$word}%");
                    });
                }
            }

            return $query;
        };

        // -------------------------
        // Base Product Query (drives the "Showing X-Y of Z" text + pagination)
        // -------------------------
        $products = Product::with(['images', 'compatibility', 'category'])
            ->where('status', 1);

        $applyFilters($products);

        // -------------------------
        // Track Customer Activity
        // -------------------------
        if (auth('customer')->check()) {
            if ($request->filled('search')) {
                $lastSearch = CustomerActivity::where('customer_id', auth('customer')->id())
                    ->where('activity_type', 'search')
                    ->where('value', $request->search)
                    ->latest()
                    ->first();

                if (!$lastSearch || $lastSearch->created_at->diffInSeconds(now()) > 30) {
                    CustomerActivity::create([
                        'customer_id' => auth('customer')->id(),
                        'activity_type' => 'search',
                        'value' => $request->search,
                    ]);
                }
            }

            if ($request->filled('category')) {
                foreach ((array) $request->category as $cat) {
                    if ($cat) {
                        CustomerActivity::updateOrCreate(
                            [
                                'customer_id' => auth('customer')->id(),
                                'activity_type' => 'category_view',
                                'reference_id' => $cat,
                            ],
                            ['updated_at' => now()]
                        );
                    }
                }
            }

            if ($request->filled('brand')) {
                CustomerActivity::updateOrCreate(
                    [
                        'customer_id' => auth('customer')->id(),
                        'activity_type' => 'brand_view',
                        'value' => $request->brand,
                    ],
                    ['updated_at' => now()]
                );
            }
        }

        // -------------------------
        // Pagination
        // -------------------------
        $products = $products->with(['images', 'category', 'reviews'])
            ->latest()
            ->paginate(16);

        // -------------------------
        // Categories for sidebar
        // -------------------------
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // -------------------------
        // Popular / Boosted products — now uses the SAME filters as $products
        // -------------------------
        $views = [];

        $baseQuery = Product::with(['images', 'reviews'])
            ->where('status', 1);

        $applyFilters($baseQuery);

        $productsBase = $baseQuery->get();

        if ($productsBase->isEmpty()) {
            // No results under current filters — nothing to boost/score
            $boostedProducts = collect();
        } else {
            $views = CustomerActivity::where('activity_type', 'product_view')
                ->whereIn('reference_id', $productsBase->pluck('id'))
                ->selectRaw('reference_id, COUNT(*) as total_views')
                ->groupBy('reference_id')
                ->pluck('total_views', 'reference_id')
                ->toArray();

            $scored = [];

            foreach ($productsBase as $p) {
                $viewsCount = $views[$p->id] ?? 0;
                $rating = round($p->averageRating() ?? 0);

                $score = 0;
                $score += $viewsCount * 5;
                $score += $rating * 2;
                if ($p->stock_quantity > 0) {
                    $score += 1;
                }
                $score += 1;

                $scored[$p->id] = $score;
            }

            arsort($scored);
            $orderedIds = array_keys($scored);

            $boostedProducts = Product::with(['images', 'reviews'])
                ->whereIn('id', $orderedIds)
                ->get()
                ->sortBy(fn($p) => -($scored[$p->id] ?? 0));
        }

        return view('Frontend.shop', compact(
            'products',
            'years',
            'brands',
            'models',
            'engines',
            'fuelTypes',
            'engineTypes',
            'categories',
            'boostedProducts',
            'views',
            'selectedVendor',
            'vendorSlug'
        ));
    }

    public function searchSuggestions(Request $request)
    {
        $search = $request->get('query');
        if (!$search) {
            return response()->json([]);
        }
        $keywords = explode(' ', $search);
        $products = \App\Models\Product::where('status', 1);
        foreach ($keywords as $word) {
            $products->where(function ($q) use ($word) {
                $q->where('name', 'like', "%{$word}%")
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$word}%"))
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$word}%"))
                    ->orWhere('description', 'like', "%{$word}%");
            });
        }

        $products = $products
            ->with(['images'])
            ->select('id', 'name', 'price')
            ->limit(8)
            ->get();

        return response()->json([
            'products' => $products,
        ]);
    }
}