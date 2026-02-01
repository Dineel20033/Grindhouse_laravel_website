<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    // Replaces logic in index.php
    public function index()
    {
        // Fetch 4 featured products (similar to the logic in your old index.php)
        $featuredProducts = [];
        if (Schema::hasTable('products')) {
            $featuredProducts = Product::orderBy('id', 'asc')->limit(4)->get();
        }

        // Fetch categories (limit to 4 for the "Shop by Category" section)
        $categories = [];
        if (Schema::hasTable('categories')) {
            $categories = \App\Models\Category::orderBy('name', 'asc')->limit(4)->get();
        }

        // Pass data to the Blade View: resources/views/home.blade.php
        return view('home', compact('featuredProducts', 'categories'));
    }
}