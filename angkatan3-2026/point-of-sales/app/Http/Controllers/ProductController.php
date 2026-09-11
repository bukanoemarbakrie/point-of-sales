<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Data Product";
        $products = Product::with('category')->orderBy('id', 'DESC')->get();
        return view('product.index', compact('title', 'products'));
    }

    public function create()
    {
        $title = "Create Product";
        $categories = Category::where('is_active', 1)->get();
        return view('product.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'category_id' => 'required|exists:categories,id',
            'product_price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_description' => 'nullable|string',
            'is_active' => 'nullable|in:0,1'
        ]);

        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price,
            'qty' => $request->qty ?? 0,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active ?? 1
        ];

        if ($request->hasFile('product_photo')) {
            $data['product_photo'] = $request->file('product_photo')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::where('is_active', 1)->get();
        $title = "Edit Product";
        return view('product.edit', compact('title', 'product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'product_price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_description' => 'nullable|string',
            'is_active' => 'nullable|in:0,1'
        ]);

        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price,
            'qty' => $request->qty ?? 0,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active ?? 1
        ];

        if ($request->hasFile('product_photo')) {
            if ($product->product_photo) {
                Storage::disk('public')->delete($product->product_photo);
            }
            $data['product_photo'] = $request->file('product_photo')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function show(string $id)
    {
        $title = "Detail Product";
        $product = Product::with('category')->findOrFail($id);
        return view('product.show', compact('title', 'product'));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->product_photo) {
            Storage::disk('public')->delete($product->product_photo);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
