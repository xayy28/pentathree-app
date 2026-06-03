@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E6E4DD] grid grid-cols-1 md:grid-cols-2">
    
    <!-- Left Side: Form -->
    <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
        <h2 class="text-3xl sm:text-4xl font-serif font-semibold text-[#2B4C3F] mb-2">
            Welcome Back
        </h2>
        <p class="text-[#5C6E65] text-sm mb-8 leading-relaxed">
            Sign in to your account to manage your stays and curated collections.
        </p>

        <!-- Session Alert Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-[#EAF2EE] border border-[#A7C5B5] text-[#2B4C3F] text-sm rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C] text-sm rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email Address Input -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                    Email Address
                </label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
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

            <!-- Password Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65]">
                        Password
                    </label>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 placeholder-[#8A9C91]"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('password', this)"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#5C6E65] hover:text-[#2B4C3F] focus:outline-none transition-colors">
                        <!-- Eye Icon -->
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 text-xs text-[#9B1C1C] font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2 text-[#5C6E65] cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-[#2B4C3F] border-[#D5D3C7] rounded focus:ring-[#2B4C3F]">
                    <span>Remember me</span>
                </label>
                <a href="#" class="text-xs font-semibold text-[#2B4C3F] hover:underline">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white py-3.5 px-4 rounded-lg font-semibold text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C3F] focus:ring-offset-2">
                Sign In
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-[#E6E4DD]"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-4 text-[#8A9C91] tracking-wider font-semibold">Or continue with</span>
            </div>
        </div>

        <!-- Google Button -->
        <button type="button" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-[#D5D3C7] rounded-lg text-sm font-semibold text-[#5C6E65] bg-white hover:bg-[#FAF9F6] transition-colors focus:outline-none">
            <svg class="w-5 h-5" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.56h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.4C21.68,11.77 21.56,11.4 21.35,11.1z" fill="#4285F4" />
                    <path d="M12,20.8c2.7,0 4.96,-0.9 6.62,-2.44l-3.3,-2.56c-0.9,0.6 -2.08,0.98 -3.32,0.98 -2.56,0 -4.72,-1.73 -5.5,-4.06H3.1v2.64C4.74,18.6 8.08,20.8 12,20.8z" fill="#34A853" />
                    <path d="M6.5,12.72c-0.2,-0.6 -0.3,-1.24 -0.3,-1.9s0.1,-1.3 0.3,-1.9V6.28H3.1C2.42,7.63 2,9.17 2,10.82c0,1.65 0.42,3.19 1.1,4.54L6.5,12.72z" fill="#FBBC05" />
                    <path d="M12,5.2c1.47,0 2.8,0.5 3.84,1.5l2.88,-2.88C17,2.26 14.73,1.3 12,1.3 8.08,1.3 4.74,3.5 3.1,6.78l3.4,2.64C7.28,7.09 9.44,5.2 12,5.2z" fill="#EA4335" />
                </g>
            </svg>
            <span>Google Account</span>
        </button>

        <p class="text-center text-sm text-[#5C6E65] mt-8">
            Don't have an account yet?
            <a href="{{ route('register') }}" class="font-semibold text-[#2B4C3F] hover:underline">Join Now</a>
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
                "True luxury is found in the space between things."
            </p>
            <div class="text-xs font-semibold uppercase tracking-wider text-[#5C6E65]">
                THE AURA COLLECTIVE
            </div>
        </div>
    </div>

</div>

<script>
    function togglePasswordVisibility(fieldId, button) {
        const input = document.getElementById(fieldId);
        const icon = button.querySelector('svg');
        
        if (input.type === 'password') {
            input.type = 'text';
            // Change icon to eye-off
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            input.type = 'password';
            // Change icon back to eye
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
</script>
@endsection
