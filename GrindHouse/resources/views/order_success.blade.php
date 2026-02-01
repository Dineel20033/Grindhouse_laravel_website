@extends('layouts.app')

@section('content')

<main class="container mx-auto py-20 px-6 text-center">
    <div class="bg-white p-12 rounded-2xl shadow-2xl max-w-xl mx-auto border-4 border-green-200">
        <h2 class="text-4xl font-extrabold text-green-600 mb-6">🎉 Order Placed Successfully!</h2>
        <p class="text-xl text-gray-700 mb-8">
            Thank you for your purchase. We have received your order.
        </p>
        
        <p class="text-2xl font-bold text-gray-800 mb-10">
            Your Order ID is: <b class="text-amber-700">#{{ $id }}</b>
        </p>
        
        <a href="{{ route('home') }}" class="bg-amber-600 text-white px-8 py-3 rounded-lg hover:bg-amber-700 font-semibold text-lg transition duration-300">
            Back to Home
        </a>
    </div>
</main>

@endsection