@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero Section (Seamless with navbar) -->
    <div class="relative h-[450px] sm:h-[550px] bg-cover bg-center flex items-center justify-center"
        style="background-image: url('{{ asset('images/hero-banner1.png') }}');">
        <!-- Dark overlay to ensure text contrast -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Hero Text Content -->
        <div class="relative z-10 text-center text-white px-4 max-w-3xl space-y-4">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.25em] uppercase block drop-shadow-sm text-white/90">
                The Art of Retreat
            </span>
            <h1 class="font-cursive text-3xl sm:text-5xl md:text-7xl font-bold leading-tight drop-shadow-md">
                Quiet spaces for intentional living.
            </h1>
        </div>
    </div>

    <!-- Main Page Container (Cool Grey Background) -->
    <div class="bg-[#F3F4F6] py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            @include('pelanggan.homestay._preview')

            @include('pelanggan.souvenir._preview')

            <!-- Section 3: Quote filosofis (Bottom) -->
            <section class="flex justify-center pt-8">
                <div
                    class="w-full max-w-4xl bg-white rounded-[40px] px-8 py-16 sm:px-16 sm:py-20 text-center space-y-6 shadow-sm border border-gray-200/60 relative overflow-hidden">
                    <!-- Subtle background light glow -->
                    <div
                        class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-white/30 blur-3xl pointer-events-none">
                    </div>

                    <!-- Quote icon -->
                    <div class="text-5xl sm:text-6xl text-[#2B4C3F]/30 font-serif leading-none select-none">
                        “
                    </div>

                    <!-- Quote Text -->
                    <p class="font-serif text-[#2C3E35] text-lg sm:text-2xl italic leading-relaxed max-w-3xl mx-auto">
                        "The Aura Collective is not just about a place to sleep; it is about finding the space between
                        things, the quiet rhythm of the valley, and the luxury of time."
                    </p>

                    <!-- Quote Close Icon -->
                    <div class="text-5xl sm:text-6xl text-[#2B4C3F]/30 font-serif leading-none select-none mt-2">
                        ”
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
