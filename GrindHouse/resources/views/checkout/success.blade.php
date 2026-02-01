@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Success Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-6">Thank you for your order. Your order number is <span class="font-semibold text-green-600">#{{ $order->id }}</span></p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-lg p-6 text-left mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h2>
                
                <div class="space-y-2 mb-4">
                    <p><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $order->customer_name }}</span></p>
                    <p><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $order->email }}</span></p>
                    <p><span class="text-gray-500">Phone:</span> <span class="font-medium">{{ $order->phone ?? 'N/A' }}</span></p>
                    <p><span class="text-gray-500">Address:</span> <span class="font-medium">{{ $order->address }}</span></p>
                </div>

                <hr class="my-4">

                <h3 class="font-semibold text-gray-900 mb-3">Items Ordered</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="flex justify-between">
                        <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
                        <span class="font-medium">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <hr class="my-4">

                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span class="text-green-600">Rs. {{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Continue Shopping
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
