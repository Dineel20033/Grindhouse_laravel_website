@extends('admin.layouts.app')

@section('title', 'Edit Product: ' . $product->name)

@section('admin_content')

<h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Product: {{ $product->name }}</h1>

<a href="{{ route('admin.products.index') }}" class="text-amber-700 hover:text-amber-900 mb-6 inline-block font-semibold">
    ← Back to Product List
</a>

<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 max-w-2xl mx-auto">
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <p class="font-bold">Please correct the following errors:</p>
            <ul class="list-disc ml-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500">
        </div>

        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (LKR) *</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500">
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
            <select name="category_id" id="category_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ (old('category_id') == $category->id || $product->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image URL *</label>
            <input type="url" name="image" id="image" value="{{ old('image', $product->image) }}" required
                   placeholder="e.g., https://example.com/image.jpg"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500">
            @if ($product->image)
                <p class="mt-2 text-sm text-gray-500">Current Image Preview:</p>
                <img src="{{ $product->image }}" alt="Current Product Image" class="w-24 h-24 object-cover rounded-lg mt-1 shadow">
            @endif
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
            <textarea name="description" id="description" rows="5" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500">{{ old('description', $product->description) }}</textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 font-semibold transition duration-300">
            Update Product
        </button>
    </form>
</div>

@endsection