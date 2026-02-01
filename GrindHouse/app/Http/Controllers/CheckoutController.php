<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        return view('checkout.index', compact('cart'));
    }

    public function placeOrder(Request $request) 
    {
        // 1. Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
        ]);
        
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $grand_total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // 2. DATABASE TRANSACTION BLOCK
        $order = DB::transaction(function () use ($validated, $grand_total, $cart, $request) {
            
            $order = Order::create([
                'user_id' => $request->user()->id,
                'customer_name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'total' => $grand_total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }
            
            return $order;
        });

        // 3. Stripe Checkout Session
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'lkr',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => (int)($item['price'] * 100), // Stripe expects cents/smallest unit
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('order.success', ['id' => $order->id]),
                'cancel_url' => route('checkout.index'),
                'customer_email' => $validated['email'],
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe error: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        // Clear cart only after successful payment redirect
        session()->forget('cart');

        $order = Order::with('items')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}