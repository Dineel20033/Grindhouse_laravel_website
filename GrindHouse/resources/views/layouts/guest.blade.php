<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GrindHouse') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .input-focus:focus {
                border-color: #d97706;
                box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
            }
            .btn-primary {
                background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(217, 119, 6, 0.3);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <livewire:video-player src="{{ asset('assets/videos/gym_video.mp4') }}" player-class="fixed inset-0 w-full h-full object-cover -z-20" />
        <div class="fixed inset-0 bg-black/40 -z-10"></div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">

            <!-- Main Card -->
            <div class="w-full sm:max-w-md px-4 sm:px-0 relative z-10">
                <div class="glass-card px-6 py-8 sm:px-10 sm:py-10 shadow-2xl rounded-2xl">
                    {{ $slot }}
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-6">
                    <a href="/" class="text-amber-400/80 hover:text-amber-300 text-sm transition-colors">
                        ← Back to Home
                    </a>
                </div>
            </div>

            <!-- Bottom Decoration -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
        </div>
        @livewireScripts
    </body>
</html>
