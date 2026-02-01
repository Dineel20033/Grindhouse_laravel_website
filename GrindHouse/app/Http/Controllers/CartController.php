<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Replaces cart.php (display cart)
    public function index()
    {
        return view('cart.index');
    }

    // Handles adding items to cart (Replaces logic in products_description.php)
    public function add(Request $request, Product $product)
    {
        $quantity = max(1, $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // Item exists, increment quantity
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // New item
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    // Handles removing items from cart (Replaces logic in cart.php)
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}