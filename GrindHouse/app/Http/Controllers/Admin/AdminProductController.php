<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource. (admin_products.php display list)
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('price', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('name', 'asc')
            ->get();

        $categories = Category::all();
        
        // This view will contain the product list and the "Add New" form
        return view('admin.products.index', compact('products', 'categories', 'search'));
    }

    /**
     * Show the form for creating a new resource. (admin_products.php: if no edit_product)
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage. (admin_products.php: 'add_product' logic)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'image' => 'required|url', // Assuming image is stored as a URL/path
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource. (admin_products.php: 'edit_product' logic)
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage. (admin_products.php: 'update_product' logic)
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|url',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage. (admin_products.php: 'delete_product' logic)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}