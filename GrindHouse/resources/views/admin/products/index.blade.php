@extends('admin.layouts.app')

@section('title', 'Manage Products')

@section('admin_content')

<h1 class="text-3xl font-bold text-gray-800 mb-8">Manage Products</h1>

<div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <form method="GET" action="{{ route('admin.products.index') }}" class="w-full md:max-w-md">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products, categories, or price..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500"
            >
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Search
            </button>
            @if (request('search'))
                <a href="{{ route('admin.products.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">
                    Clear
                </a>
            @endif
        </div>
    </form>

    <div class="text-right">
        <a href="{{ route('admin.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
            + Add New Product
        </a>
    </div>
</div>

<!-- Desktop Table -->
<div class="hidden md:block bg-white rounded-xl shadow-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr class="bg-gray-50">
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Image</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Price (LKR)</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($products as $product)
                <tr>
                    <td class="px-4 py-2 text-center">
                        <img src="{{ $product->image }}" class="w-16 h-16 mx-auto rounded-lg object-cover">
                    </td>
                    <td class="px-4 py-2 font-medium">{{ $product->name }}</td>
                    <td class="px-4 py-2 text-center">{{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-2 text-center">{{ $product->category->name }}</td>
                    <td class="px-4 py-2 max-w-xs">{{ Str::limit($product->description, 40) }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card List -->
<div class="md:hidden space-y-4">
    @forelse ($products as $product)
        <div class="bg-white p-4 rounded-xl shadow border border-gray-100 flex gap-4">
            <!-- Image -->
            <div class="flex-shrink-0">
                <img src="{{ $product->image }}" class="w-20 h-20 rounded-lg object-cover bg-gray-50">
            </div>
            
            <!-- Content -->
            <div class="flex-grow flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start">
                         <h3 class="font-bold text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                         <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $product->category->name }}</span>
                    </div>
                    <p class="text-amber-700 font-bold text-sm mt-1">LKR {{ number_format($product->price, 2) }}</p>
                </div>

                <div class="flex gap-2 mt-3 justify-end">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded text-xs font-semibold">Edit</a>
                    
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 text-red-700 px-3 py-1.5 rounded text-xs font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">No products found.</p>
    @endforelse
</div>

@endsection