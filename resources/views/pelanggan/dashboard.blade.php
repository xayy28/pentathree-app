@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
    {{-- Banner Verifikasi Email --}}
    @if(auth()->check() && ! auth()->user()->hasVerifiedEmail())
        <div class="bg-amber-50 border-b border-amber-200 px-4 py-3">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Email Anda belum terverifikasi.</p>
                        <p class="text-xs text-amber-700 mt-0.5">
                            Silakan verifikasi email Anda agar dapat menggunakan seluruh fitur sistem.
                        </p>
                    </div>
                </div>
                <form action="{{ route('verification.send') }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Kirim Email Verifikasi
                    </button>
                </form>
            </div>
        </div>
    @endif

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
