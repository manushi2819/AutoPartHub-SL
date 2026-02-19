<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? true,
        ]);

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


    // UPDATE
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
