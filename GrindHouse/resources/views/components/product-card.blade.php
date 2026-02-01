@props(['product', 'badge' => null])

<div
    class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden h-full relative">
    <div class="relative w-full overflow-hidden bg-gray-100 border-b border-gray-100" style="aspect-ratio: 4/3;">
        <img src="{{ $product->image }}" alt="{{ $product->name }}"
            class="absolute inset-0 w-full h-full object-cover object-center transform group-hover:scale-110 transition duration-700 ease-in-out">

        @if($badge)
            <div class="absolute top-2 right-2 md:top-3 md:right-3 z-10">
                <span class="bg-amber-600 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase shadow-sm">
                    {{ $badge }}
                </span>
            </div>
        @endif
    </div>

    <div class="p-3 md:p-5 flex flex-col flex-grow relative border-t border-gray-50">
        <div class="flex-grow">
            <h3
                class="text-sm md:text-lg font-bold text-gray-900 leading-tight mb-1 md:mb-2 transition-colors line-clamp-2">
                {{ $product->name }}
            </h3>
            <div class="mb-2 md:mb-3">
                <span class="text-base md:text-xl font-extrabold text-amber-600">
                    LKR {{ number_format($product->price, 2) }}
                </span>
            </div>
        </div>

        <div class="mt-auto pt-2 md:pt-3 border-t border-gray-100">
            <a href="{{ route('products.show', $product) }}"
                class="flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-2 md:py-3 md:px-6 rounded-lg md:rounded-xl transition-all duration-300 shadow-md hover:shadow-lg gap-1.5 md:gap-2 text-xs md:text-lg md:font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Add to Cart
            </a>
        </div>
    </div>
</div>