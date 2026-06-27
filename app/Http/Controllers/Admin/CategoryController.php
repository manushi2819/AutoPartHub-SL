<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    // INDEX
    public function index()
    {
        $categories = Category::with('children.children')
            ->whereNull('parent_id')
            ->get();

        return view('AdminDashboard.Categories.index', compact('categories'));
    }

    // CREATE
    public function create()
    {
        $categories = Category::all(); // all categories
        return view('AdminDashboard.Categories.create', compact('categories'));
    }


    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vendor_commission_percentage' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10248'
        ]);

        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? true,
            'vendor_commission_percentage' => $request->input('vendor_commission_percentage', 0),
        ];

        // Only allow image for parent category
        if(!$request->parent_id && $request->hasFile('image')){

            $path = public_path('uploads/category_images');
            File::ensureDirectoryExists($path);

            $fileName = time().'_'.uniqid().'.'.$request->image->extension();
            $request->image->move($path, $fileName);

            $data['image'] = 'uploads/category_images/'.$fileName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    // EDIT
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get(); // exclude current category
        return view('AdminDashboard.Categories.edit', compact('category', 'categories'));
    }



    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'vendor_commission_percentage' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10248',
        ]);

        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? true,
            'vendor_commission_percentage' => $request->input('vendor_commission_percentage', 0),
        ];
        // Only allow image for parent category
        if(!$request->parent_id){

            if($request->hasFile('image')){

                // delete old image
                if($category->image && File::exists(public_path($category->image))){
                    File::delete(public_path($category->image));
                }

                $path = public_path('uploads/category_images');
                File::ensureDirectoryExists($path);

                $fileName = time().'_'.uniqid().'.'.$request->image->extension();
                $request->image->move($path,$fileName);

                $data['image'] = 'uploads/category_images/'.$fileName;
            }

        } else {
            // if converting to child category remove image
            if($category->image && File::exists(public_path($category->image))){
                File::delete(public_path($category->image));
            }

            $data['image'] = null;
        }
        $category->update($data);
        return redirect()->route('admin.categories.index')
            ->with('success','Category updated successfully.');
    }


    // DELETE
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
