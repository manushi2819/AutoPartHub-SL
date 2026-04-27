<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVehicleCompatibility;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleImage;

class HomeController extends Controller
{

    public function index() {

        // dropdown filters (your existing code)
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
        $brands = Brand::where('status', 1)->get();

        $parentCategories = Category::with('children.children')
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('name')
        ->limit(20)
        ->get();

        // calculate product count
        foreach($parentCategories as $category){

            $categoryIds = [$category->id];

            foreach($category->children as $child){
                $categoryIds[] = $child->id;

                foreach($child->children as $subchild){
                    $categoryIds[] = $subchild->id;
                }
            }

            $category->product_count = Product::whereIn('category_id',$categoryIds)->count();
        }


        // Get all parent categories with children
        $allParents = Category::with('children.children')
            ->whereNull('parent_id')
            ->where('status', 1)
            ->get();

        // Filter parents that have at least 3 products
        $filterCategories = collect();

        foreach ($allParents as $parent) {

            // Collect category IDs for parent + children + subchildren
            $categoryIdsForParent = [$parent->id];
            foreach ($parent->children as $child) {
                $categoryIdsForParent[] = $child->id;
                foreach ($child->children as $subchild) {
                    $categoryIdsForParent[] = $subchild->id;
                }
            }

            // Count products under this parent
            $productCount = Product::where('status',1)
                ->whereIn('category_id', $categoryIdsForParent)
                ->count();

            // Only include if at least 3 products
            if ($productCount >= 3) {
                $parent->product_count = $productCount;
                $filterCategories->push($parent);
            }
        }

        // Limit to 4 parent categories
        $filterCategories = $filterCategories->take(4);

        // Collect all category IDs from these filtered parents for product query
        $categoryIds = [];
        foreach ($filterCategories as $parent) {
            $categoryIds[] = $parent->id;
            foreach ($parent->children as $child) {
                $categoryIds[] = $child->id;
                foreach ($child->children as $subchild) {
                    $categoryIds[] = $subchild->id;
                }
            }
        }

        // Fetch latest 12 products under the filtered categories
        $latestProducts = Product::with(['images','category','reviews'])
            ->where('status',1)
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->take(12)
            ->get();

        // Attach parent category ID to products for filtering
        foreach ($latestProducts as $product) {
            $category = $product->category;
            while ($category && $category->parent_id) {
                $category = Category::find($category->parent_id);
            }
            $product->parent_category_id = $category->id ?? $product->category_id;
        }

        // Get featured vehicles (you can modify the criteria as needed)
        $featuredVehicles = Vehicle::with(['brand', 'mainImage'])
            ->where('status', 1) // Only available vehicles
            ->orderBy('created_at', 'desc')
            ->limit(6) // Show 6 vehicles on homepage
            ->get();
        
        // Optional: Get statistics for dashboard
        $totalVehicles = Vehicle::where('status', 1)->count();
        $totalBrands = Brand::count();
        
        // Get popular brands (vehicles count per brand)
        $popularBrands = Brand::withCount('vehicles')
            ->having('vehicles_count', '>', 0)
            ->orderBy('vehicles_count', 'desc')
            ->limit(8)
            ->get();

        return view('Frontend.index', compact(
            'years',
            'brands',
            'models',
            'engines',
            'fuelTypes',
            'engineTypes',
            'parentCategories',
            'filterCategories',
            'latestProducts',
            'featuredVehicles',
            'totalVehicles',
            'totalBrands',
            'popularBrands',
            
        ));
    }


     public function about() {
        return view('Frontend.about');
    }

     public function contact() {
        return view('Frontend.contact');
    }

   
}
