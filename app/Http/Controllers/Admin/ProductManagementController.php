<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'required',
        ]);

        // Generate 7-digit ID: 2 digit code (based on category prefix) + 5 digit random number
        $prefix = strtoupper(substr($request->category, 0, 2));
        $number = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $productId = $prefix . $number;

        Product::create([
            'product_id' => $productId,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($product)
    {
        $product = Product::findOrFail($product);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}
