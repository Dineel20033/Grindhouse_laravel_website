@extends('layouts.app')

@section('content')

    <main class="container mx-auto py-8 md:py-16 px-4 md:px-6">
        <h2 class="text-2xl md:text-3xl font-bold mb-8 md:mb-12 text-center text-amber-700 dark:text-amber-500 lg:dark:text-amber-700">Contact Us</h2>

        <div class="grid md:grid-cols-2 gap-6 md:gap-12">

            <div class="hidden md:flex justify-center md:justify-end h-full">
                <div class="relative w-full max-w-lg h-full min-h-[600px] rounded-2xl overflow-hidden shadow-2xl border border-amber-200 dark:border-zinc-700 lg:dark:border-amber-200 bg-black">
                    <livewire:video-player 
                        src="{{ asset('assets/videos/gym_video_contact.mp4') }}" 
                        player-class="absolute inset-0 w-full h-full object-cover object-center"
                    />
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 lg:dark:bg-white p-4 md:p-8 rounded-2xl shadow-2xl border border-amber-200 dark:border-zinc-700 lg:dark:border-amber-200 w-full max-w-lg h-full flex flex-col justify-center">
                <h3 class="text-xl md:text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 lg:dark:text-gray-800 text-center md:text-left">Get in Touch</h3>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 lg:dark:text-gray-600 mb-6 leading-relaxed text-center md:text-left">
                    Have questions about our equipment or services? Our team at <b>GRINDHOUSE.LK</b> is ready to help. Fill
                    out the form below.
                </p>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="first_name" placeholder="First Name *" value="{{ old('first_name') }}"
                            required
                            class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400 @error('first_name') border-red-500 @enderror">

                        <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}"
                            class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400 @error('last_name') border-red-500 @enderror">
                    </div>

                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div>
                        <input type="email" name="email" placeholder="Email *" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400 @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <textarea name="message" rows="5" placeholder="Write your message here..." required
                            class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-900 dark:text-gray-100 lg:dark:border-gray-300 lg:dark:bg-white lg:dark:text-gray-900 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-400 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 font-semibold transition duration-300 shadow-md">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </main>

@endsection