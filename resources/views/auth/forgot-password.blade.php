@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E6E4DD] grid grid-cols-1 md:grid-cols-2">
    
    <!-- Left Side: Form -->
    <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
        <h2 class="text-3xl sm:text-4xl font-serif font-semibold text-[#2B4C3F] mb-2">
            Reset Password
        </h2>
        <p class="text-[#5C6E65] text-sm mb-8 leading-relaxed">
            Enter your email address and we will send you a link to reset your password.
        </p>

        <!-- Session Alert Notification -->
        @if(session('status') || session('success'))
            <div class="mb-6 p-4 bg-[#EAF2EE] border border-[#A7C5B5] text-[#2B4C3F] text-sm rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('status') ?? session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C] text-sm rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email Address Input -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                    Email Address
                </label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 placeholder-[#8A9C91]"
                           placeholder="name@example.com">
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-[#9B1C1C] font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white py-3.5 px-4 rounded-lg font-semibold text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C3F] focus:ring-offset-2">
                Send Reset Link
            </button>
        </form>

        <p class="text-center text-sm text-[#5C6E65] mt-8">
            Remember your password?
            <a href="{{ route('login') }}" class="font-semibold text-[#2B4C3F] hover:underline">Sign In</a>
        </p>
    </div>

    <!-- Right Side: Image and Quote -->
    <div class="hidden md:block relative min-h-[500px] bg-cover bg-center" 
         style="background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=85');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-[#2B4C3F]/20 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        <!-- Testimonial Box -->
        <div class="absolute bottom-10 left-10 right-10 bg-white/95 backdrop-blur-sm p-6 rounded-xl border border-white/20 shadow-lg">
            <p class="font-serif italic text-lg text-[#2B4C3F] mb-3 leading-relaxed">
                "Finding your way back to tranquility."
            </p>
            <div class="text-xs font-semibold uppercase tracking-wider text-[#5C6E65]">
                THE AURA COLLECTIVE
            </div>
        </div>
    </div>

</div>
@endsection
