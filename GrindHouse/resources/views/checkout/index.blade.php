@extends('layouts.app')

@section('content')

<main class="container mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-8 text-green-600 text-center md:text-left">Finalize Your Order</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-xl font-semibold mb-6 text-gray-800 border-b pb-3">Shipping Details</h3>

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
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <input type="email" name="email" placeholder="Email *" value="{{ old('email', Auth::user()->email ?? '') }}" required 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <input type="text" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">
                
                <textarea name="address" rows="4" placeholder="Shipping Address *" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400">{{ old('address') }}</textarea>
                
                <button type="submit" name="place_order" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold w-full">
                  Place Order
                </button>
            </form>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h3>
            <div class="bg-white border rounded-lg shadow p-6">
                @php
                    $cart = session('cart', []);
                    $grand_total = 0;
                @endphp
                
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2 text-sm">Product</th>
                            <th class="text-center py-2 text-sm">Qty</th>
                            <th class="text-right py-2 text-sm">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            @php
                                $line_total = $item['price'] * $item['quantity'];
                                $grand_total += $line_total;
                            @endphp
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 text-sm">{{ $item['name'] }}</td>
                                <td class="text-center py-2 text-sm">{{ $item['quantity'] }}</td>
                                <td class="text-right py-2 font-medium text-sm">LKR {{ number_format($line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3 class="text-xl font-bold text-right mt-4 pt-4 border-t border-gray-200">
                    Total: <span class="text-amber-700">LKR {{ number_format($grand_total, 2) }}</span>
                </h3>
            </div>
        </div>
    </div>
</main>

@endsection