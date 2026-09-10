<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $title = 'Data Category';
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('category.index', compact('title', 'categories'));
    }

    public function create()
    {
        $title = 'Create New Category';
        return view('category.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
            'is_active' => 'required|in:0,1'
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function edit(string $id)
    {
        $title = "Edit Category";
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id,
            'is_active' => 'required|in:0,1'
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
