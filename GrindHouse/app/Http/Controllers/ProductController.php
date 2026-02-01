<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource (All Products).
     * Replaces products.php logic.
     */
    public function index(Request $request)
    {
        // Now handled by Livewire\Volt ProductCatalog component
        return view('products.index');
    }

    /**
     * Display the specified resource (Single Product).
     * Replaces products_description.php logic.
     */
    public function show(Product $product)
    {
        // Laravel's route model binding automatically fetches the product
        // based on the ID in the URL, replacing complex manual fetch/check.
        
        return view('products.show', compact('product'));
    }
    
    // The resource route definition only asked for index and show,
    // so no create, store, edit, update, or destroy methods are needed here.
}