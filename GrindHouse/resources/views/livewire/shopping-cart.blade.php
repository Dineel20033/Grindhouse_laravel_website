<?php

use Livewire\Volt\Component;

new class extends Component {
    public $cart = [];
    public $total = 0;

    public function mount()
    {
        $this->updateCartState();
    }

    public function updateCartState()
    {
        $this->cart = session('cart', []);
        $this->total = array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
            session()->put('cart', $this->cart);
            $this->updateCartState();
            
            // Dispatch event to update header cart count if we had a header component
            // $this->dispatch('cart-updated'); 
        }
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id])) {
            if ($this->cart[$id]['quantity'] > 1) {
                $this->cart[$id]['quantity']--;
                session()->put('cart', $this->cart);
            } else {
                $this->remove($id);
                return;
            }
            $this->updateCartState();
        }
    }

    public function remove($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            session()->put('cart', $this->cart);
            $this->updateCartState();
        }
    }
    
    public function clearCart()
    {
        session()->forget('cart');
        $this->updateCartState();
    }
}; ?>

<div class="bg-white dark:bg-zinc-800 lg:dark:bg-white rounded-xl shadow-lg overflow-hidden">
    @if (!empty($cart))
        
        {{-- Desktop Table View --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700 lg:dark:divide-gray-200">
                <thead class="bg-gray-50 dark:bg-zinc-700 lg:dark:bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 lg:dark:text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 lg:dark:text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 lg:dark:text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 lg:dark:text-gray-500 uppercase tracking-wider">Subtotal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 lg:dark:text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700 lg:dark:divide-gray-200">
                    @foreach ($cart as $id => $item)
                        <tr wire:key="{{ $id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if(isset($item['image']))
                                    <div class="flex-shrink-0 h-10 w-10 mr-4">
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    </div>
                                    @endif
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 lg:dark:text-gray-900">{{ $item['name'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700 dark:text-gray-300 lg:dark:text-gray-700">
                                LKR {{ number_format($item['price'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button type="button" wire:click="decrement('{{ $id }}')" class="p-1 rounded-full bg-gray-100 dark:bg-zinc-700 lg:dark:bg-gray-100 hover:bg-gray-200 dark:hover:bg-zinc-600 lg:dark:hover:bg-gray-200 text-gray-600 dark:text-gray-300 lg:dark:text-gray-600 focus:outline-none transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="text-sm font-medium w-6 text-center text-gray-900 dark:text-gray-100 lg:dark:text-gray-900">{{ $item['quantity'] }}</span>
                                    <button type="button" wire:click="increment('{{ $id }}')" class="p-1 rounded-full bg-gray-100 dark:bg-zinc-700 lg:dark:bg-gray-100 hover:bg-gray-200 dark:hover:bg-zinc-600 lg:dark:hover:bg-gray-200 text-gray-600 dark:text-gray-300 lg:dark:text-gray-600 focus:outline-none transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 dark:text-gray-100 lg:dark:text-gray-900">
                                LKR {{ number_format($item['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <button type="button" wire:click="remove('{{ $id }}')" class="text-red-500 hover:text-red-700 font-medium transition flex items-center justify-end ml-auto gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile List View --}}
        <div class="md:hidden divide-y divide-gray-200 dark:divide-zinc-700 lg:dark:divide-gray-200">
            @foreach ($cart as $id => $item)
                <div class="p-4" wire:key="mobile-cart-item-{{ $id }}">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-3">
                             @if(isset($item['image']))
                                <img class="h-16 w-16 rounded-lg object-cover bg-gray-50 dark:bg-zinc-700 lg:dark:bg-gray-50" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 lg:dark:text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 lg:dark:text-gray-500 text-xs">LKR {{ number_format($item['price'], 2) }} / unit</p>
                            </div>
                        </div>
                         <button type="button" wire:click.prevent="remove('{{ $id }}')" class="text-gray-400 dark:text-gray-500 lg:dark:text-gray-400 hover:text-red-500 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="flex justify-between items-center mt-3">
                        <div class="flex items-center space-x-3 bg-gray-50 dark:bg-zinc-700 lg:dark:bg-gray-50 rounded-lg p-1">
                            <button type="button" wire:click.prevent="decrement('{{ $id }}')" class="p-1.5 rounded-md bg-white dark:bg-zinc-600 lg:dark:bg-white shadow-sm text-gray-600 dark:text-gray-300 lg:dark:text-gray-600 hover:text-amber-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <span class="font-bold text-gray-800 dark:text-gray-100 lg:dark:text-gray-800 w-6 text-center">{{ $item['quantity'] }}</span>
                            <button type="button" wire:click.prevent="increment('{{ $id }}')" class="p-1.5 rounded-md bg-white dark:bg-zinc-600 lg:dark:bg-white shadow-sm text-gray-600 dark:text-gray-300 lg:dark:text-gray-600 hover:text-amber-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                        <span class="font-extrabold text-amber-600 dark:text-amber-500 lg:dark:text-amber-600">LKR {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer / Totals --}}
        <div class="bg-gray-50 p-6 border-t border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg font-medium text-gray-600">Total Amount</span>
                <span class="text-2xl font-bold text-gray-900">LKR {{ number_format($total, 2) }}</span>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <button type="button" wire:click.prevent="clearCart" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition text-center">
                    Clear Cart
                </button>
                <a href="{{ route('checkout.index') }}" 
                   class="px-8 py-3 bg-amber-600 text-white rounded-lg font-bold hover:bg-amber-700 shadow-md hover:shadow-lg transition text-center flex items-center justify-center gap-2">
                    Proceed to Checkout
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

    @else
        <div class="p-10 text-center flex flex-col items-center justify-center">
            <div class="bg-amber-50 rounded-full p-6 mb-4">
               <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-8">Looks like you haven't added any fitness gear yet.</p>
            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition shadow">
                Start Shopping
            </a>
        </div>
    @endif
</div>
