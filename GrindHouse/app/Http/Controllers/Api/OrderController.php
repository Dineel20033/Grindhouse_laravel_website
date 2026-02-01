<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::with('items')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->whereNull('user_id')
                         ->where('email', $user->email);
                  });
            })
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['data' => $orders]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'required|string',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Create Order
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'customer_name' => $request->customer_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'total' => $request->total,
                ]);

                // Create Order Items
                foreach ($request->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_name' => $item['product_name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'order_id' => $order->id
                ], 201);
            });
        } catch (\Exception $e) {
            Log::error('API Checkout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
    }
}
