<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GRINDHOUSE.LK') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 font-sans antialiased pb-24 md:pb-0">
    <div class="min-h-screen flex flex-col">

        <header class="bg-amber-100 dark:bg-zinc-900 shadow-lg relative z-50">
            <div class="max-w-7xl mx-auto px-4 md:px-6 flex items-center justify-between py-2">
                <a href="{{ route('home') }}" class="flex items-center md:-ml-20">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo"
                        class="w-24 md:w-32 opacity-90 mix-blend-multiply dark:opacity-100 dark:mix-blend-normal dark:invert md:dark:opacity-90 md:dark:mix-blend-multiply md:dark:filter-none">
                </a>

                <nav class="hidden md:flex space-x-14">
                    <a href="{{ route('home') }}"
                        class="text-base md:text-lg text-gray-800 dark:text-gray-100 font-medium hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-zinc-800 px-3 py-2 rounded-lg transition">Home</a>
                    <a href="{{ route('products.index') }}"
                        class="text-base md:text-lg text-gray-800 dark:text-gray-100 font-medium hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-zinc-800 px-3 py-2 rounded-lg transition">Products</a>
                    <a href="{{ route('about') }}"
                        class="text-base md:text-lg text-gray-800 dark:text-gray-100 font-medium hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-zinc-800 px-3 py-2 rounded-lg transition">About
                        Us</a>
                    <a href="{{ route('contact.index') }}"
                        class="text-base md:text-lg text-gray-800 dark:text-gray-100 font-medium hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-zinc-800 px-3 py-2 rounded-lg transition">Contact
                        Us</a>
                </nav>

                <div class="flex items-center space-x-6 md:space-x-12 md:-mr-8">
                    @auth

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center space-x-2 text-gray-800 dark:text-gray-100 hover:text-amber-600 focus:outline-none">
                                <img src="{{ asset('assets/login.png') }}" alt="User"
                                    class="w-7 h-7 md:w-9 md:h-9 rounded-full border border-gray-300">
                                <span class="font-medium text-sm md:text-base">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                style="display: none;"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                                <div class="py-1">
                                    @if(Auth::user()->is_admin === true)
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 last:rounded-b-lg">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('login') }}"
                                class="flex items-center space-x-1 text-gray-800 dark:text-gray-100 hover:text-amber-600">
                                <img src="{{ asset('assets/login.png') }}" alt="Login" class="w-6 h-6 md:w-8 md:h-8">
                                <span class="font-medium text-sm md:text-base">Sign In</span>
                            </a>
                        </div>
                    @endauth

                    @php
                        $cart = session('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}"
                        class="relative inline-block text-gray-800 dark:text-gray-100 hover:text-amber-600 transition-colors">
                        <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-grow">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <footer class="bg-amber-100 py-8 md:py-12 text-gray-900 mt-auto">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 md:gap-2">
                {{-- Logo Section - Full width on very small screens, 1 col on others --}}
                <div
                    class="col-span-2 sm:col-span-1 md:col-span-1 flex flex-col items-center md:items-start text-center md:text-left md:-ml-32">
                    <h2 class="font-bold text-base md:text-lg mb-3 tracking-wider">GRINDHOUSE.LK</h2>
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo"
                        class="w-20 md:w-28 opacity-90 mix-blend-multiply">
                </div>

                {{-- About --}}
                <div class="col-span-1 text-center md:text-left flex flex-col items-center md:items-start md:ml-32">
                    <h3 class="font-bold text-sm md:text-base mb-3 text-amber-900 tracking-wide">ABOUT</h3>
                    <p class="text-xs md:text-sm leading-relaxed text-gray-700">
                        GRINDHOUSE (PVT) LTD<br>18, Maharagama,<br>Colombo
                    </p>
                </div>

                {{-- Contact --}}
                <div class="col-span-1 text-center md:text-left flex flex-col items-center md:items-start md:ml-32">
                    <h3 class="font-bold text-sm md:text-base mb-3 text-amber-900 tracking-wide">CONTACT</h3>
                    <p class="text-xs md:text-sm text-gray-700 mb-1 font-medium">+94 112 123 456</p>
                    <p class="text-[11px] md:text-sm text-gray-700 break-all">info@grindhouse.lk</p>
                </div>

                {{-- Links --}}
                <div
                    class="col-span-2 sm:col-span-1 md:col-span-1 text-center md:text-left flex flex-col items-center md:items-start md:ml-32">
                    <h3 class="font-bold text-sm md:text-base mb-3 text-amber-900 tracking-wide">LINKS</h3>
                    <ul class="flex md:flex-col gap-4 md:gap-2 text-xs md:text-sm font-medium text-gray-700">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-700 transition">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-amber-700 transition">Products</a>
                        </li>
                        <li><a href="{{ route('about') }}" class="hover:text-amber-700 transition">About</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-amber-700 transition">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-amber-200 mt-8 pt-6 text-center text-[10px] md:text-xs text-gray-600 px-4">
                © {{ date('Y') }} GRINDHOUSE.LK. All rights reserved.
            </div>
        </footer>
    </div>

    <!-- Mobile Navigation -->
    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 px-6 py-2 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <div class="flex justify-between items-end text-[10px] font-medium text-gray-500">
            <!-- Home -->
            <a href="{{ route('home') }}"
                class="flex flex-col items-center w-16 space-y-1 hover:text-amber-600 transition-colors {{ request()->routeIs('home') ? 'text-amber-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Home</span>
            </a>

            <!-- Products -->
            <a href="{{ route('products.index') }}"
                class="flex flex-col items-center w-16 space-y-1 hover:text-amber-600 transition-colors {{ request()->routeIs('products.*') ? 'text-amber-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Products</span>
            </a>

            <!-- Contact -->
            <a href="{{ route('contact.index') }}"
                class="flex flex-col items-center w-16 space-y-1 hover:text-amber-600 transition-colors {{ request()->routeIs('contact.*') ? 'text-amber-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Contact</span>
            </a>

            <!-- Auth -->
            @auth
                <a href="{{ route('profile.edit') }}"
                    class="flex flex-col items-center min-w-[4rem] px-1 space-y-1 hover:text-amber-600 transition-colors {{ request()->routeIs('profile.*') ? 'text-amber-600' : '' }}">
                    @if(Auth::user()->is_admin)
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                    <span class="text-center whitespace-nowrap">{{ Auth::user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="flex flex-col items-center w-16 space-y-1 hover:text-amber-600 transition-colors {{ request()->routeIs('login') ? 'text-amber-600' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Sign In</span>
                </a>
            @endauth
        </div>
    </nav>
    @stack('modals')
    @livewireScripts
</body>

</html>