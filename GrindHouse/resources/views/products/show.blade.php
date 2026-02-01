@extends('layouts.app')

@section('content')

<main class="container mx-auto py-6 md:py-12 px-4 md:px-6">
    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-10 border-b pb-4">Product Details</h2>

    <div class="bg-white p-4 md:p-8 rounded-xl shadow-2xl flex flex-col md:flex-row gap-6 md:gap-10">
        <div class="md:w-1/2">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                 class="w-full h-auto max-h-[400px] md:h-96 object-contain md:object-cover rounded-lg shadow-md md:shadow-xl bg-gray-50">
        </div>

        <div class="md:w-1/2 flex flex-col justify-between">
            <div>
                <h3 class="text-2xl md:text-3xl font-bold mb-2 md:mb-3 text-gray-900">{{ $product->name }}</h3>
                <p class="text-lg md:text-xl text-amber-600 font-semibold mb-4 md:mb-6">
                    LKR {{ number_format($product->price, 2) }}
                </p>
                <div class="text-sm md:text-base text-gray-700 mb-6 md:mb-8 whitespace-pre-line leading-relaxed">
                    {{ $product->description }}
                </div>
                <p class="text-xs md:text-sm text-gray-500 bg-gray-100 w-fit px-2 py-1 rounded">Category: {{ $product->category->name }}</p>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex flex-col gap-4 mt-6">
                @csrf
                <div class="flex items-center gap-4">
                    <label for="quantity" class="font-semibold text-gray-700">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" required
                           class="w-20 px-3 py-2 border rounded-lg text-center focus:ring-amber-500 focus:border-amber-500">
                </div>
                
                <button type="submit" 
                        class="bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 font-semibold transition duration-300 shadow-md w-full md:w-auto">
                    Add to Cart
                </button>
            </form>
            
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</main>

@endsection