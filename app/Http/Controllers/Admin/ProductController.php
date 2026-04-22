<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\VehicleType;
use App\Models\ProductVehicleCompatibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $products = Product::with(['category', 'images'])->get();
        return view('AdminDashboard.Products.index', compact('products'));
    }

    // ================= CREATE =================
    public function create()
    {
        $categories = Category::with('children.children')->whereNull('parent_id')->get();
        $brands = Brand::where('status', 1)->get();
        $vehicleTypes = VehicleType::where('status', 1)->get();
        return view('AdminDashboard.Products.create', compact('categories', 'brands', 'vehicleTypes'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $product = Product::with(['images', 'compatibility'])->findOrFail($id);
        $categories = Category::with('children.children')->whereNull('parent_id')->get();
        $brands = Brand::where('status', 1)->get();
        $vehicleTypes = VehicleType::where('status', 1)->get();
        return view('AdminDashboard.Products.create', compact('product', 'categories', 'brands', 'vehicleTypes'));
    }



     // ================= store =================
    public function store(Request $request)
    {
      $data = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'sku' => 'nullable|string|max:255',
        'brand_id' => 'nullable|exists:brands,id',
        'price' => 'required|numeric',
        'cost_price' => 'nullable|numeric',
        'stock_quantity' => 'required|integer',
        'status' => 'required|boolean',
        'description' => 'nullable|string',
        'small_description' => 'nullable|string',
        'compatibility_model' => 'nullable|string|max:255',
        'compatibility_year_from' => 'nullable|integer',
        'compatibility_year_to' => 'nullable|integer',
        'engine_type' => 'nullable|string|max:255',
        'engine_cc' => 'nullable|integer',
        'fuel_type' => 'nullable|string|max:255',
        'transmission' => 'nullable|string|max:255',
        'vehicle_type_ids' => 'nullable|array',
        'vehicle_type_ids.*' => 'exists:vehicle_types,id',
    ]);

        $lastSku = \App\Models\Product::whereNotNull('sku')
            ->where('sku', 'like', 'SKU%')
            ->orderBy('sku', 'desc')
            ->value('sku');

        if ($lastSku) {
            // extract number part
            $number = (int) str_replace('SKU', '', $lastSku);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        // format: SKU0001, SKU0020 etc.
        $sku = 'SKU' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $data['sku'] = $sku;

        $product = Product::create($data);

        // Create single compatibility
        if ($request->filled('brand_id')) {

            $brand = \App\Models\Brand::find($request->brand_id);

            $product->compatibility()->create([
                'brand' => $brand->name ?? null, 
                'model' => $request->compatibility_model,
                'year_from' => $request->compatibility_year_from,
                'year_to' => $request->compatibility_year_to,
                'engine_type' => $request->engine_type,
                'engine_cc' => $request->engine_cc,
                'fuel_type' => $request->fuel_type,
                'transmission' => $request->transmission,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    

     // ================= update =================
    public function update(Request $request, Product $product)
    {
        \Log::info('UPDATE PRODUCT REQUEST:', $request->all());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'small_description' => 'nullable|string',
            'compatibility_model' => 'nullable|string|max:255',
            'compatibility_year_from' => 'nullable|integer',
            'compatibility_year_to' => 'nullable|integer',
            'engine_type' => 'nullable|string|max:255',
            'engine_cc' => 'nullable|integer',
            'fuel_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'vehicle_type_ids' => 'nullable|array',
            'vehicle_type_ids.*' => 'exists:vehicle_types,id',
        ]);

        \Log::info('VALIDATED DATA:', $data);
        \Log::info('BEFORE UPDATE PRODUCT:', $product->toArray());

        $product->update($data);

        \Log::info('AFTER UPDATE PRODUCT:', $product->fresh()->toArray());

        // Update or create single compatibility
        if (
            $request->filled('compatibility_model') ||
            $request->filled('compatibility_year_from') ||
            $request->filled('compatibility_year_to')
        ) {
            $brand = \App\Models\Brand::find($request->brand_id);

            $product->compatibility()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'brand' => $brand->name ?? null,
                    'model' => $request->compatibility_model,
                    'year_from' => $request->compatibility_year_from,
                    'year_to' => $request->compatibility_year_to,
                    'engine_type' => $request->engine_type,
                    'engine_cc' => $request->engine_cc,
                    'fuel_type' => $request->fuel_type,
                    'transmission' => $request->transmission,
                ]
            );
        }

          return back()->with('success', 'Product updates successfully.');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete images from public/uploads
        foreach($product->images as $img) {
            if(File::exists(public_path('uploads/' . $img->image_url))){
                File::delete(public_path('uploads/' . $img->image_url));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    // ================= UPLOAD IMAGES =================
    public function uploadImages(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if($request->hasFile('images')){
            $first = true; // flag for the first image
            foreach($request->file('images') as $image){
                $filename = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $filename,
                    'is_main' => $first, // first image = true, others = false
                ]);

                $first = false; // after the first iteration, set to false
            }
        }

        return back()->with('success', 'Images uploaded successfully.');
    }



    public function deleteImage(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);

        if (File::exists(public_path('uploads/' . $image->image_url))) {
            File::delete(public_path('uploads/' . $image->image_url));
        }

        $image->delete();

        // Respond differently for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Image deleted.');
    }

}
