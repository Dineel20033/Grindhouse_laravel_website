@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('admin_content')

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Category: {{ $category->name }}</h1>

    <div class="max-w-md bg-white p-6 rounded-2xl shadow-xl">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    class="w-full p-3 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">Category Image URL</label>
                <input type="url" name="image_url" id="image_url"
                    value="{{ old('image_url', filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : '') }}"
                    placeholder="https://example.com/image.jpg"
                    class="w-full p-3 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                <p class="text-xs text-gray-500 mt-1">Current Image: {{ $category->image }}</p>
                @error('image_url')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.categories.index') }}"
                    class="text-gray-600 hover:text-gray-800 font-medium">Cancel</a>
                <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Update Category
                </button>
            </div>
        </form>
    </div>

@endsection