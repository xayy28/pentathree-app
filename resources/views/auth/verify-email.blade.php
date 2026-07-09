@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('content')
    <div
        class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E6E4DD] grid grid-cols-1 md:grid-cols-2">

        <!-- Left Side: Content -->
        <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-[#EAF2EE] rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-[#2B4C3F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h2 class="text-3xl sm:text-4xl font-serif font-semibold text-[#2B4C3F] mb-2">
                Verifikasi Email Anda
            </h2>
            <p class="text-[#5C6E65] text-sm mb-8 leading-relaxed">
                Kami telah mengirimkan link verifikasi ke alamat email Anda.
                Silakan periksa inbox (atau folder spam) dan klik link tersebut untuk mengaktifkan akun Anda.
            </p>

            <!-- Status Notification -->
            @if(session('status'))
                <div
                    class="mb-6 p-4 bg-[#EAF2EE] border border-[#A7C5B5] text-[#2B4C3F] text-sm rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div
                    class="mb-6 p-4 bg-[#FFF8EC] border border-[#F5DCA5] text-[#92620E] text-sm rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-5 mb-8 space-y-3">
                <div class="flex items-start gap-3 text-sm text-[#5C6E65]">
                    <svg class="w-4 h-4 mt-0.5 text-[#2B4C3F] flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Email dikirim ke <strong class="text-[#2B4C3F]">{{ auth()->user()->email }}</strong></span>
                </div>
                <div class="flex items-start gap-3 text-sm text-[#5C6E65]">
                    <svg class="w-4 h-4 mt-0.5 text-[#2B4C3F] flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Link verifikasi berlaku selama <strong class="text-[#2B4C3F]">60 menit</strong>.</span>
                </div>
            </div>

            <!-- Resend Form -->
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white py-3.5 px-4 rounded-lg font-semibold text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C3F] focus:ring-offset-2">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Back to dashboard -->
            <p class="text-center text-sm text-[#5C6E65] mt-6">
                Kembali ke
                <a href="{{ route('dashboard') }}" class="font-semibold text-[#2B4C3F] hover:underline">Dashboard</a>
            </p>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mt-3 text-center">
                @csrf
                <button type="submit" class="text-xs text-[#8A9C91] hover:text-[#2B4C3F] hover:underline transition-colors">
                    Keluar dari akun ini
                </button>
            </form>
        </div>

        <!-- Right Side: Image and Quote -->
        <div class="hidden md:block relative min-h-[500px] bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=85');">
            <div class="absolute inset-0 bg-[#2B4C3F]/20 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            <div
                class="absolute bottom-10 left-10 right-10 bg-white/95 backdrop-blur-sm p-6 rounded-xl border border-white/20 shadow-lg">
                <p class="font-serif italic text-lg text-[#2B4C3F] mb-3 leading-relaxed">
                    "A verified stay is a secure stay."
                </p>
                <div class="text-xs font-semibold uppercase tracking-wider text-[#5C6E65]">
                    NATASHA HOMESTAY
                </div>
            </div>
        </div>

    </div>
@endsection