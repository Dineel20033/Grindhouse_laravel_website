@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('admin_content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg border border-amber-200">
            <h3 class="text-xl font-semibold text-gray-500">Products</h3>
            <p class="text-4xl font-bold text-amber-700 mt-2">{{ $productCount }}</p>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-500 hover:text-blue-700 mt-3 block">View Products →</a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-amber-200">
            <h3 class="text-xl font-semibold text-gray-500">Total Orders</h3>
            <p class="text-4xl font-bold text-amber-700 mt-2">{{ $orderCount }}</p>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-500 hover:text-blue-700 mt-3 block">View Orders →</a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg border border-amber-200">
            <h3 class="text-xl font-semibold text-gray-500">New Messages</h3>
            <p class="text-4xl font-bold text-amber-700 mt-2">{{ $messageCount }}</p>
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-blue-500 hover:text-blue-700 mt-3 block">View Messages →</a>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mt-12 mb-6">Latest Orders</h2>
    
    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($latestOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">LKR {{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent orders.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @forelse ($latestOrders as $order)
            <div class="bg-white p-4 rounded-xl shadow border border-gray-100 flex flex-col gap-2">
                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="font-mono text-sm text-gray-500">#{{ $order->id }}</span>
                    <span class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-amber-700">LKR {{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">No recent orders.</p>
        @endforelse
    </div>

@endsection