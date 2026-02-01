<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - GrindHouse</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .admin-gradient {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus:focus {
            border-color: #d97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
        }

        .btn-admin {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.3);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 admin-gradient">
        <!-- Logo Section -->
        <div class="mb-6">
            <div class="flex flex-col items-center">
                <div
                    class="w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl flex items-center justify-center shadow-2xl">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                </div>
                <h1 class="mt-4 text-3xl font-bold text-white tracking-wider">Admin Panel</h1>
                <p class="text-amber-400/80 text-sm mt-1">GrindHouse Management</p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="w-full sm:max-w-xl mx-4">
            <div class="glass-card px-8 py-10 shadow-2xl rounded-2xl">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
                    <p class="text-gray-500 mt-2">Access the management dashboard</p>
                </div>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <ul class="text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2 ml-3">Email
                            Address</label>
                        <div
                            class="flex items-center w-full bg-gray-50/50 border border-gray-200 rounded-xl focus-within:ring-4 focus-within:ring-amber-500/15 focus-within:bg-white focus-within:border-amber-600 transition-all duration-200">
                            <div
                                class="w-10 flex-shrink-0 flex items-center justify-center text-gray-400 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-0 pr-4 py-3 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2 ml-3">Password</label>
                        <div
                            class="flex items-center w-full bg-gray-50/50 border border-gray-200 rounded-xl focus-within:ring-4 focus-within:ring-amber-500/15 focus-within:bg-white focus-within:border-amber-600 transition-all duration-200">
                            <div
                                class="w-10 flex-shrink-0 flex items-center justify-center text-gray-400 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="w-full pl-0 pr-2 py-3 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400"
                                placeholder="Enter your password">

                            <button type="button" onclick="togglePassword('password')"
                                class="w-10 flex-shrink-0 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none flex-shrink-0">
                                <svg id="password_eye" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500 transition">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full btn-admin text-white font-semibold py-3 px-4 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        Sign In to Dashboard
                    </button>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-amber-400/80 hover:text-amber-300 text-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Customer Login
                </a>
            </div>
        </div>

        <!-- Bottom Decoration -->
        <div
            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent">
        </div>
    </div>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const eye = document.getElementById(id + '_eye');
            if (input.type === 'password') {
                input.type = 'text';
                eye.querySelector('.eye-open').classList.add('hidden');
                eye.querySelector('.eye-closed').classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.querySelector('.eye-open').classList.remove('hidden');
                eye.querySelector('.eye-closed').classList.add('hidden');
            }
        }
    </script>
</body>

</html>