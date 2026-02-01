<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;

    // Reset pagination when search/filter changes
    public function updatedSearch() { $this->resetPage(); }
    public function updatedSelectedCategory() { $this->resetPage(); }

    public function with()
    {
        $products = Product::query()
            ->when($this->search, fn (Builder $query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->selectedCategory, fn (Builder $query) => $query->where('category_id', $this->selectedCategory))
            ->orderBy('name', 'asc')
            ->paginate(12);

        return [
            'products' => $products,
            'categories' => Category::all(),
        ];
    }
    
    // Mount to capture query parameter initial state
    public function mount()
    {
        $this->selectedCategory = request()->query('category');
    }
}; ?>

<div class="max-w-7xl mx-auto py-10 px-4 md:px-6 md:flex md:items-start md:gap-8">

    {{-- Sidebar --}}
    <aside class="hidden md:block w-64 flex-shrink-0 bg-white p-6 rounded-xl shadow-lg h-fit sticky top-24">
        <h3 class="text-xl font-bold text-amber-700 mb-6 border-b pb-3">Product Categories</h3>
        <nav class="space-y-3">
            <button wire:click="$set('selectedCategory', null)" 
               class="w-full text-left px-4 py-3 rounded-xl transition-all duration-200 flex justify-between items-center group mb-2
                      {{ is_null($selectedCategory) ? 'bg-amber-600 text-white font-bold shadow-md transform scale-105' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700 hover:shadow-sm' }}">
                <span>All Products</span>
                @if(is_null($selectedCategory))
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                @endif
            </button>
            
            @foreach ($categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})" 
                   class="w-full text-left px-4 py-3 rounded-xl transition-all duration-200 flex justify-between items-center group mb-1
                          {{ $selectedCategory == $category->id ? 'bg-amber-600 text-white font-bold shadow-md transform scale-105' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700 hover:shadow-sm' }}">
                    <span>{{ $category->name }}</span>
                    @if($selectedCategory == $category->id)
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    @endif
                </button>
            @endforeach
        </nav>
    </aside>

    {{-- Mobile Category Dropdown --}}
    <div class="md:hidden mb-6 flex flex-col gap-4">
        
        {{-- Mobile Search --}}
        <div class="relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between bg-amber-50 p-3 rounded-lg border border-amber-100">
            <div class="flex items-center gap-2 text-amber-900 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <span>Category</span>
            </div>
            <select wire:model.live="selectedCategory" class="form-select block w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md shadow-sm">
                <option value="">All Products</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <section class="md:flex-grow">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 md:mt-2">
            <h2 class="text-xl md:text-3xl font-bold text-amber-700">
                @if ($selectedCategory)
                    {{ $categories->firstWhere('id', $selectedCategory)?->name }} Equipment
                @else
                    All Fitness Equipment
                @endif
            </h2>
            
            {{-- Desktop Search --}}
            <div class="hidden md:block relative w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm transition duration-150 ease-in-out">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Loading State --}}
        <div wire:loading class="w-full text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-amber-500 border-t-transparent"></div>
            <p class="mt-2 text-amber-600 font-medium">Loading products...</p>
        </div>

        <div wire:loading.remove>
            @if ($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or category filter.</p>
                    <button wire:click="$set('search', '')" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Clear Search
                    </button>
                </div>
            @endif
        </div>
    </section>
</div>
