@extends('layouts.app')

@section('content')

<main class="container mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-8 text-green-600 dark:text-green-500 lg:dark:text-green-600 text-center md:text-left">Finalize Your Order</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 bg-white dark:bg-zinc-800 lg:dark:bg-white p-8 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200">
            <h3 class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-100 lg:dark:text-gray-800 border-b dark:border-zinc-700 lg:dark:border-gray-200 pb-3">Shipping Details</h3>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.placeOrder') }}" method="POST" class="space-y-5">
                @csrf
                
                <input type="text" name="name" placeholder="Full Name *" value="{{ old('name', Auth::user()->name ?? '') }}" required 
                       class="w-full border border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <input type="email" name="email" placeholder="Email *" value="{{ old('email', Auth::user()->email ?? '') }}" required 
                       class="w-full border border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <input type="text" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" 
                       class="w-full border border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <textarea name="address" rows="4" placeholder="Shipping Address *" required
                          class="w-full border border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">{{ old('address') }}</textarea>
                
                <button type="submit" name="place_order" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold w-full">
                  Place Order
                </button>
            </form>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 lg:dark:text-gray-800">Order Summary</h3>
            <div class="bg-white dark:bg-zinc-800 lg:dark:bg-white border dark:border-zinc-700 lg:dark:border-gray-200 rounded-lg shadow p-6">
                @php
                    $cart = session('cart', []);
                    $grand_total = 0;
                @endphp
                
                <table class="w-full">
                    <thead>
                        <tr class="border-b dark:border-zinc-700 lg:dark:border-gray-200">
                            <th class="text-left py-2 text-sm text-gray-600 dark:text-gray-300 lg:dark:text-gray-600">Product</th>
                            <th class="text-center py-2 text-sm text-gray-600 dark:text-gray-300 lg:dark:text-gray-600">Qty</th>
                            <th class="text-right py-2 text-sm text-gray-600 dark:text-gray-300 lg:dark:text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            @php
                                $line_total = $item['price'] * $item['quantity'];
                                $grand_total += $line_total;
                            @endphp
                            <tr class="border-b dark:border-zinc-700 lg:dark:border-gray-200 last:border-b-0">
                                <td class="py-2 text-sm text-gray-800 dark:text-gray-100 lg:dark:text-gray-800">{{ $item['name'] }}</td>
                                <td class="text-center py-2 text-sm text-gray-800 dark:text-gray-100 lg:dark:text-gray-800">{{ $item['quantity'] }}</td>
                                <td class="text-right py-2 font-medium text-sm text-gray-800 dark:text-gray-100 lg:dark:text-gray-800">LKR {{ number_format($line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3 class="text-xl font-bold text-right mt-4 pt-4 border-t border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200 text-gray-900 dark:text-white lg:dark:text-gray-900">
                    Total: <span class="text-amber-700 dark:text-amber-500 lg:dark:text-amber-700">LKR {{ number_format($grand_total, 2) }}</span>
                </h3>
            </div>
        </div>
    </div>
</main>

@endsection