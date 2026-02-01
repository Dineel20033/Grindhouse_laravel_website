@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative bg-black h-[50vh] md:h-[70vh] flex items-center justify-center overflow-hidden">
        <livewire:video-player src="{{ asset('assets/videos/gym_video_about.mp4') }}" player-class="absolute inset-0 w-full h-full object-cover" />
        <!-- Overlay for text readability -->
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white p-6">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-8 uppercase tracking-wide">
                Forging Greatness at <span class="text-amber-600">GRINDHOUSE</span>
            </h1>
            <p class="text-lg md:text-2xl font-light mb-8 tracking-wider leading-relaxed">
                Empowering your fitness journey with premium equipment and unwavering support
            </p>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-block px-4 py-2 bg-amber-100 rounded-full text-amber-800 text-sm font-semibold mb-6">
                        Our Mission
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Empowering Every Fitness Journey
                    </h2>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        The mission of Grindhouse Fitness is to empower individuals at every stage of their fitness journey. We believe that everyone, whether a professional athlete or a casual home gym enthusiast, should have access to high-quality, durable, and efficient exercise equipment that supports their goals and enhances their performance.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        At Grindhouse Fitness, we are dedicated to offering a carefully curated selection of top-notch equipment designed to maximize results, ensure safety, and provide long-lasting value. Beyond simply providing products, we aim to inspire, educate, and motivate our customers to push their limits, improve overall health, and achieve the physique they've always dreamed of.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        By combining superior equipment with a commitment to customer success, Grindhouse Fitness makes every workout experience seamless, enjoyable, and truly transformative, helping people reach their fitness goals with confidence and consistency.
                    </p>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-r from-amber-200 to-amber-100 rounded-2xl blur-2xl opacity-30"></div>
                        <img src="{{ asset('assets/mission_bg.jpg') }}" alt="Workout at Grindhouse" class="relative w-full aspect-[4/3] object-cover rounded-2xl shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Community Section -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="order-1 lg:order-1">
                    <div class="relative w-full">
                        <div class="absolute -inset-4 bg-gradient-to-r from-amber-200 to-amber-100 rounded-2xl blur-2xl opacity-30"></div>
                        <img src="{{ asset('assets/community_gym.png') }}" alt="Grindhouse Community" class="relative w-full aspect-[4/3] object-cover rounded-2xl shadow-2xl">
                    </div>
                </div>

                <div class="order-2 lg:order-2">
                    <div class="inline-block px-4 py-2 bg-amber-100 rounded-full text-amber-800 text-sm font-semibold mb-6">
                        Our Community
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        More Than Just a Store
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-6">
                        <p>
                            We are more than just a store; we are a vibrant community committed to supporting you at every stage of your fitness journey. We understand the dedication, discipline, and motivation required to maintain a healthy and active lifestyle, and we are here to help make that process easier, more effective, and enjoyable.
                        </p>
                        <p>
                            Whether you are searching for the perfect set of dumbbells to enhance your home workouts, a high-quality treadmill for consistent cardio sessions, or a complete, professional-grade setup for a commercial facility, our passionate and knowledgeable staff is always available to provide expert guidance, personalized recommendations, and ongoing support.
                        </p>
                        <p>
                            At Grindhouse Fitness, we believe in empowering our customers one piece of equipment at a time, helping you build strength, endurance, and confidence while creating a healthier, more resilient version of yourself. We are dedicated not only to providing exceptional products but also to fostering a community that motivates, educates, and celebrates every achievement along your fitness journey.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-amber-100 rounded-full text-amber-800 text-sm font-semibold mb-6">
                    Core Values
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    What We Stand For
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Our values guide everything we do, from product selection to customer service
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Quality First</h3>
                    <p class="text-gray-700 leading-relaxed">
                        We never compromise on quality. Every product is carefully selected to meet the highest standards of durability and performance.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Customer Focus</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Your success is our success. We're committed to providing personalized support and guidance every step of the way.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Innovation</h3>
                    <p class="text-gray-700 leading-relaxed">
                        We stay ahead of fitness trends, constantly updating our inventory with the latest and most effective equipment.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Fair Value</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Premium quality doesn't have to mean premium prices. We offer competitive pricing on all our products.
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Education</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Knowledge is power. We educate our customers on proper equipment use and effective training techniques.
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="bg-gradient-to-br from-amber-50 to-white p-8 rounded-2xl border border-amber-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Integrity</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Honesty and transparency in all our dealings. We build trust through consistent, reliable service.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection