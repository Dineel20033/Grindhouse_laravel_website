@extends('layouts.app')

@section('content')

    <section class="relative bg-black h-[50vh] md:h-[70vh] flex items-center justify-center overflow-hidden">
        <livewire:video-player src="{{ asset('assets/videos/gym_video.mp4') }}" player-class="absolute inset-0 w-full h-full object-cover" />
        <!-- Overlay for text readability -->
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white p-6">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 uppercase tracking-wider">
                GRINDHOUSE.LK
            </h1>
            <p class="text-lg md:text-2xl font-light mb-8">
                Unleash your strength. Equip your journey.
            </p>
            <a href="{{ route('products.index') }}"
                class="bg-amber-600 hover:bg-amber-700 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-xl transition duration-300">
                Shop Now
            </a>
        </div>
    </section>




    <!-- Distinct Categories Section -->
    <section class="py-8 md:py-16 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-amber-700">Browse Categories</h2>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-8">
                @forelse ($categories as $category)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col group cursor-pointer" onclick="window.location='{{ route('products.index', ['category' => $category->id]) }}'">
                        @php
                            $imagePath = $category->image;
                            if (empty($imagePath)) {
                                $imageUrl = asset('assets/default.png');
                            } elseif (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                $imageUrl = $imagePath;
                            } else {
                                $imageUrl = asset($imagePath);
                            }
                        @endphp
                        <div class="relative h-32 md:h-48 overflow-hidden">
                             <img src="{{ $imageUrl }}"
                            alt="{{ $category->name }}"
                            onerror="this.onerror=null; this.src='{{ asset('assets/default.png') }}';"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        </div>
                       
                        <div class="p-3 md:p-5 flex flex-col flex-grow items-center justify-center">
                            <h3 class="text-sm md:text-xl font-bold text-gray-800 text-center mb-1 md:mb-2">{{ $category->name }}</h3>
                            
                            <span class="text-[10px] md:text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-full border border-gray-200 w-fit">{{ $category->products->count() }} Products</span>
                        </div>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">No categories found.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-amber-700">Featured Products</h2>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-8">
                @forelse ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="col-span-4 text-center text-gray-500">No featured products available.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8 md:py-16 bg-amber-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-gray-800">Why Choose Us</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-3 md:p-6 rounded-xl shadow-md text-center hover:-translate-y-2 transition duration-300 h-full flex flex-col justify-center">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center mb-2 md:mb-4 text-amber-600 text-xl md:text-3xl">
                        💡
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-gray-800 mb-1 md:mb-2">Expert Advice</h3>
                    <p class="text-gray-600 text-[10px] md:text-sm leading-tight md:leading-normal">
                        Our knowledgeable staff is always ready to provide expert advice on equipment that suits your needs.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-3 md:p-6 rounded-xl shadow-md text-center hover:-translate-y-2 transition duration-300 h-full flex flex-col justify-center">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center mb-2 md:mb-4 text-amber-600 text-xl md:text-3xl">
                        👍
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-gray-800 mb-1 md:mb-2">Unique Selection</h3>
                    <p class="text-gray-600 text-[10px] md:text-sm leading-tight md:leading-normal">
                        Explore a diverse range of gym equipment tailored to meet all fitness levels and preferences.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-3 md:p-6 rounded-xl shadow-md text-center hover:-translate-y-2 transition duration-300 h-full flex flex-col justify-center">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-2 md:mb-4 text-green-600 text-xl md:text-3xl">
                        💲
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-gray-800 mb-1 md:mb-2">Competitive Prices</h3>
                    <p class="text-gray-600 text-[10px] md:text-sm leading-tight md:leading-normal">
                        We offer competitive pricing on all our products, giving you great value without compromising quality.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-3 md:p-6 rounded-xl shadow-md text-center hover:-translate-y-2 transition duration-300 h-full flex flex-col justify-center">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-2 md:mb-4 text-blue-600 text-xl md:text-3xl">
                        🛡️
                    </div>
                    <h3 class="text-sm md:text-xl font-bold text-gray-800 mb-1 md:mb-2 text-wrap">Satisfaction Guarantee</h3>
                    <p class="text-gray-600 text-[10px] md:text-sm leading-tight md:leading-normal">
                        We stand by our products with a satisfaction guarantee, ensuring your investment is protected.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection