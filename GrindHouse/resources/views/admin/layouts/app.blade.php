<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-amber-50 min-h-screen flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header -->
    <header class="md:hidden bg-amber-800 text-white p-4 flex justify-between items-center shadow-md relative z-20">
        <h2 class="text-xl font-bold">Admin Panel</h2>
        <button @click="sidebarOpen = !sidebarOpen" class="focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-amber-800 text-white p-6 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex-shrink-0 shadow-lg">
        
        <div class="flex justify-between items-center md:block mb-8 border-b border-amber-600 pb-3">
             <h2 class="text-2xl font-bold">Admin Panel</h2>
             <button @click="sidebarOpen = false" class="md:hidden focus:outline-none text-amber-200 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex flex-col space-y-3">
            <a href="{{ route('admin.dashboard') }}"
                class="py-2 px-3 rounded-lg hover:bg-amber-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-900 font-semibold' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}"
                class="py-2 px-3 rounded-lg hover:bg-amber-700 transition {{ request()->routeIs('admin.products.*') ? 'bg-amber-900 font-semibold' : '' }}">
                Products
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="py-2 px-3 rounded-lg hover:bg-amber-700 transition {{ request()->routeIs('admin.categories.*') ? 'bg-amber-900 font-semibold' : '' }}">
                Categories
            </a>
            <a href="{{ route('admin.orders.index') }}"
                class="py-2 px-3 rounded-lg hover:bg-amber-700 transition {{ request()->routeIs('admin.orders.*') ? 'bg-amber-900 font-semibold' : '' }}">
                Orders
            </a>
            <a href="{{ route('admin.messages.index') }}"
                class="py-2 px-3 rounded-lg hover:bg-amber-700 transition {{ request()->routeIs('admin.messages.*') ? 'bg-amber-900 font-semibold' : '' }}">
                Contact Messages
            </a>
            <div class="pt-4 mt-4 border-t border-amber-600">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-3 rounded-lg hover:bg-amber-700 text-white transition">
                        Log Out
                    </button>
                </form>
                <a href="{{ route('home') }}" class="py-2 px-3 rounded-lg hover:bg-amber-700 block mt-2 transition">
                    ← Back to Store
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-grow p-4 md:p-10 transition-all duration-300">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('admin_content')
    </main>

</body>

</html>