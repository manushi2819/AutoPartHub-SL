<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVehicleCompatibility;
use App\Models\Brand;

class HomeController extends Controller
{

    public function index() {

        // dropdown filters (your existing code)
        $years = ProductVehicleCompatibility::select('year_from')->distinct()->orderBy('year_from','desc')->pluck('year_from');
        $models = ProductVehicleCompatibility::select('model')->distinct()->orderBy('model')->pluck('model');
        $engines = ProductVehicleCompatibility::select('engine_cc')->distinct()->orderBy('engine_cc')->pluck('engine_cc');
        $fuelTypes = ProductVehicleCompatibility::select('fuel_type')->distinct()->pluck('fuel_type');
        $engineTypes = ProductVehicleCompatibility::select('engine_type')->distinct()->pluck('engine_type');
        $brands = Brand::where('status', 1)->get();

        // Parent categories
        $parentCategories = Category::with('children.children')
            ->whereNull('parent_id')
            ->where('status',1)
            ->orderBy('name')
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

        return view('Frontend.index', compact(
            'years',
            'brands',
            'models',
            'engines',
            'fuelTypes',
            'engineTypes',
            'parentCategories',
            'filterCategories',
            'latestProducts'
        ));
    }


     public function about() {
        return view('Frontend.about');
    }

     public function contact() {
        return view('Frontend.contact');
    }

   
}
