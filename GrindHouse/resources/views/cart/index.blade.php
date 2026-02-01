@extends('layouts.app')

@section('content')

<main class="container mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold mb-8 text-amber-700 dark:text-amber-500 lg:dark:text-amber-700 text-center md:text-left">🛒 Your Shopping Cart</h2>

    <livewire:shopping-cart />

</main>

@endsection