<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // Display all brands
    public function index()
    {
        $brands = Brand::all();
        return view('AdminDashboard.Brand.index', compact('brands'));
    }

    // Store a new brand
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $brand->image = $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    // Update an existing brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && file_exists(public_path('uploads/' . $brand->image))) {
                unlink(public_path('uploads/' . $brand->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $brand->image = $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    // Delete a brand
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image && file_exists(public_path('uploads/' . $brand->image))) {
            unlink(public_path('uploads/' . $brand->image));
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}