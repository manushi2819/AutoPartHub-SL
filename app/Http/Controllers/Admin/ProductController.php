<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
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
        return view('AdminDashboard.Products.create', compact('categories', 'brands'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $product = Product::with(['images', 'compatibility'])->findOrFail($id);
        $categories = Category::with('children.children')->whereNull('parent_id')->get();
        $brands = Brand::where('status', 1)->get();
        return view('AdminDashboard.Products.create', compact('product', 'categories', 'brands'));
    }



     // ================= store =================
    public function store(Request $request)
    {
      $data = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'sku' => 'nullable|string|max:255',
        'brand' => 'nullable|string|max:255',
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
    ]);

        // Auto-generate SKU if not provided
        if (empty($data['sku'])) {
            // Take first 3 letters of name (uppercase) + timestamp
            $namePart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $data['name']), 0, 3));
            $data['sku'] = $namePart . '-' . time(); // e.g., TOY-170820261234
        }

        $product = Product::create($data);

        // Create single compatibility
        if ($request->filled('compatibility_brand')) {
            $product->compatibility()->create([
                'brand' => $request->brand,
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'small_description' => 'nullable|string',
            'compatibility_model' => 'required|string|max:255',
            'compatibility_year_from' => 'required|integer',
            'compatibility_year_to' => 'nullable|integer',
            'engine_type' => 'nullable|string|max:255',
            'engine_cc' => 'nullable|integer',
            'fuel_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255'
        ]);

        $product->update($data);

        // Update or create single compatibility
        $product->compatibility()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'brand' => $request->brand,
                'model' => $request->compatibility_model,
                'year_from' => $request->compatibility_year_from,
                'year_to' => $request->compatibility_year_to,
                'engine_type' => $request->engine_type,
                'engine_cc' => $request->engine_cc,
                'fuel_type' => $request->fuel_type,
                'transmission' => $request->transmission,
            ]
        );

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
