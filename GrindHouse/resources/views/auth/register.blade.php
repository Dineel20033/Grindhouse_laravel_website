<x-guest-layout>
    <div class="text-center mb-6 md:mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 lg:dark:text-gray-900 mb-2">Create account</h2>
        <p class="text-gray-500 dark:text-gray-400 lg:dark:text-gray-500 text-sm">Join us to get started with your account</p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ show: false, showConfirm: false }">
        @csrf

        {{-- Name --}}
        <div>
            <x-label for="name" value="{{ __('Full Name') }}" class="text-gray-700 dark:text-gray-300 lg:dark:text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500 lg:dark:text-gray-400">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" class="block w-full pl-10 pr-3 py-3 border border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200 rounded-lg bg-gray-50 dark:bg-zinc-800 lg:dark:bg-gray-50 text-gray-900 dark:text-gray-100 lg:dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-300 input-focus" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
            </div>
        </div>

        {{-- Email --}}
        <div>
            <x-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 dark:text-gray-300 lg:dark:text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500 lg:dark:text-gray-400">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-3 border border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200 rounded-lg bg-gray-50 dark:bg-zinc-800 lg:dark:bg-gray-50 text-gray-900 dark:text-gray-100 lg:dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-300 input-focus" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address" />
            </div>
        </div>

        {{-- Password --}}
        <div>
            <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 dark:text-gray-300 lg:dark:text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500 lg:dark:text-gray-400">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" class="block w-full pl-10 pr-10 py-3 border border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200 rounded-lg bg-gray-50 dark:bg-zinc-800 lg:dark:bg-gray-50 text-gray-900 dark:text-gray-100 lg:dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-300 input-focus" name="password" required autocomplete="new-password" placeholder="Create a password" />
                
                {{-- Toggle Password Visibility --}}
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 lg:dark:text-gray-400" @click="show = !show">
                    <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 dark:text-gray-300 lg:dark:text-gray-700 font-semibold mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500 lg:dark:text-gray-400">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" class="block w-full pl-10 pr-10 py-3 border border-gray-200 dark:border-zinc-700 lg:dark:border-gray-200 rounded-lg bg-gray-50 dark:bg-zinc-800 lg:dark:bg-gray-50 text-gray-900 dark:text-gray-100 lg:dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-300 input-focus" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" />
                
                {{-- Toggle Password Visibility --}}
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 lg:dark:text-gray-400" @click="showConfirm = !showConfirm">
                    <svg x-show="!showConfirm" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showConfirm" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </div>
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <label for="terms" class="flex items-center">
                    <x-checkbox name="terms" id="terms" required class="text-amber-600 focus:ring-amber-500" />

                    <div class="ms-2">
                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">'.__('Privacy Policy').'</a>',
                        ]) !!}
                    </div>
                </label>
            </div>
        @endif

        <div class="mt-8">
            <button type="submit" class="w-full btn-primary text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform hover:-translate-y-0.5">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400 lg:dark:text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-700 transition-colors">
                    {{ __('Sign In') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
