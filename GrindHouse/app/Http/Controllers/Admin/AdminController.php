<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ContactMessage;

class AdminController extends Controller
{
    // Replaces dashboard.php (for Admin role)
    public function dashboard()
    {
        // Fetch data for the dashboard view
        $productCount = Product::count();
        $orderCount = Order::count();
        $messageCount = ContactMessage::count();
        $latestOrders = Order::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('productCount', 'orderCount', 'messageCount', 'latestOrders'));
    }
}