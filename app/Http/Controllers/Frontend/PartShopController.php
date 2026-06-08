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
        $years = range(1980, 2026);
            rsort($years); // optional: to show latest first

        $models = ProductVehicleCompatibility::select('model')
            ->whereNotNull('model')
            ->where('model', '!=', '') // optional (avoid empty strings)
            ->distinct()
            ->orderBy('model')
            ->pluck('model');

        $brands = Brand::where('status', 1)->get();
        $engines = [800, 1000, 1300, 1500, 1800, 2000, 2500, 3000];

        $fuelTypes = ['Petrol', 'Diesel', 'Hybrid', 'Electric', 'Gas'];

        $engineTypes = ['Inline', 'Boxer', 'Rotary', 'V4' , 'V8' , 'V6', 'W2', 'Inline 2' ,'V2'];

        // -------------------------
        // Base Product Query
        // -------------------------
        $products = Product::with(['images', 'compatibility', 'category'])
            ->where('status', 1);

        // -------------------------
        // Vehicle Filters (OR)
        // -------------------------
       $products->when($request->filled('year'), function($q) use ($request) {
            $year = $request->year;

            $q->whereHas('compatibility', function($q2) use ($year) {
                $q2->where('year_from', $year);
            });
        });
        
        $products->when($request->filled('brand'), function($q) use ($request) {
            $q->whereHas('compatibility', fn($q2) => $q2->where('brand', $request->brand));
        });

        $products->when($request->filled('model'), function($q) use ($request) {
            $q->whereHas('compatibility', function($q2) use ($request){
                $q2->where('model', 'like', '%' . $request->model . '%');
            });
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

        $products->when($request->vehicle_type, function ($q) use ($request) {
            $value = $request->vehicle_type;

            $q->where(function ($sub) use ($value) {
                $sub->whereJsonContains('vehicle_type_ids', (int) $value)
                    ->orWhereJsonContains('vehicle_type_ids', (string) $value);
            });
        });

        // -------------------------
        // Category Filter
        // -------------------------
        $categoryIds = [];
        if ($request->filled('category')) {
            $selected = array_filter((array) $request->category);
            if (!empty($selected)) {
                $categoryIds = Category::getAllDescendantIds($selected);
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
       $search = $request->get('query') ?? $request->get('search');
        if ($search) {
            $keywords = explode(' ', $search);
            foreach ($keywords as $word) {
                $products->where(function ($q) use ($word) {
                    $q->where('name', 'like', "%{$word}%")

                    ->orWhereHas('brand', function ($b) use ($word) {
                        $b->where('name', 'like', "%{$word}%");
                    })

                    ->orWhereHas('category', function ($c) use ($word) {
                        $c->where('name', 'like', "%{$word}%");
                    })
                    ->orWhere('description', 'like', "%{$word}%");
                });
            }
        }
        
        // -------------------------
        // Track Customer Activity
        // -------------------------
        if(auth('customer')->check())
        {
            // Search tracking
           if ($request->filled('search')) {
                $lastSearch = CustomerActivity::where('customer_id', auth('customer')->id())
                    ->where('activity_type', 'search')
                    ->where('value', $request->search)
                    ->latest()
                    ->first();

                if (! $lastSearch || $lastSearch->created_at->diffInSeconds(now()) > 30) {
                    CustomerActivity::create([
                        'customer_id' => auth('customer')->id(),
                        'activity_type' => 'search',
                        'value' => $request->search
                    ]);
                }
            }

            // Category tracking
           if ($request->filled('category')) {
                foreach ((array) $request->category as $cat) {
                    if ($cat) {
                        CustomerActivity::updateOrCreate(
                            [
                                'customer_id' => auth('customer')->id(),
                                'activity_type' => 'category_view',
                                'reference_id' => $cat,
                            ],
                            [
                                'updated_at' => now()
                            ]
                        );
                    }
                }
            }

            // Brand tracking
           if ($request->filled('brand')) {
                CustomerActivity::updateOrCreate(
                    [
                        'customer_id' => auth('customer')->id(),
                        'activity_type' => 'brand_view',
                        'value' => $request->brand,
                    ],
                    [
                        'updated_at' => now()
                    ]
                );
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


     // -------------------------
// Popular / Boosted products for category
// -------------------------

$categoryIds = $categoryIds ?? [];

$boostedProducts = collect();

/*
|--------------------------------------------------------------------------
| STEP 1: BASE PRODUCTS (ALWAYS SAFE)
|--------------------------------------------------------------------------
*/

$baseQuery = Product::with(['images', 'reviews'])
    ->where('status', 1);

if (!empty($categoryIds)) {
    $baseQuery->whereIn('category_id', $categoryIds);
}

$productsBase = $baseQuery->get();

/*
|--------------------------------------------------------------------------
| STEP 2: IF NO CATEGORY FILTER → JUST RETURN NORMAL PRODUCTS
|--------------------------------------------------------------------------
*/

if ($productsBase->isEmpty()) {
    $boostedProducts = Product::with(['images','reviews'])
        ->where('status', 1)
        ->latest()
        ->take(8)
        ->get();
} else {

    /*
    |--------------------------------------------------------------------------
    | STEP 3: GET VIEW COUNTS
    |--------------------------------------------------------------------------
    */

    $views = CustomerActivity::where('activity_type', 'product_view')
        ->whereIn('reference_id', $productsBase->pluck('id'))
        ->selectRaw('reference_id, COUNT(*) as total_views')
        ->groupBy('reference_id')
        ->pluck('total_views', 'reference_id')
        ->toArray();

    /*
    |--------------------------------------------------------------------------
    | STEP 4: SCORING SYSTEM
    |--------------------------------------------------------------------------
    */

    $scored = [];

    foreach ($productsBase as $p) {

        $viewsCount = $views[$p->id] ?? 0;
        $rating = round($p->averageRating() ?? 0);

        $score = 0;

        // views boost (strong)
        $score += $viewsCount * 5;

        // rating boost
        $score += $rating * 2;

        // stock boost
        if ($p->stock_quantity > 0) {
            $score += 1;
        }

        // base score so everything appears
        $score += 1;

        $scored[$p->id] = $score;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 5: SORT PRODUCTS
    |--------------------------------------------------------------------------
    */

    arsort($scored);

    $orderedIds = array_keys($scored);

    $boostedProducts = Product::with(['images','reviews'])
        ->whereIn('id', $orderedIds)
        ->get()
        ->sortBy(function ($p) use ($scored) {
            return -($scored[$p->id] ?? 0);
        });
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
            'views' 
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
                ->orWhereHas('brand', function ($b) use ($word) {
                    $b->where('name', 'like', "%{$word}%");
                })
                ->orWhereHas('category', function ($c) use ($word) {
                    $c->where('name', 'like', "%{$word}%");
                })
                ->orWhere('description', 'like', "%{$word}%");

            });
        }

        $products = $products
            ->with(['images'])
            ->select('id', 'name', 'price')
            ->limit(8)
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }


}