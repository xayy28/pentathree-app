@extends('layouts.auth')

@section('title', 'Set New Password')

@section('content')
<div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E6E4DD] grid grid-cols-1 md:grid-cols-2">
    
    <!-- Left Side: Form -->
    <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
        <h2 class="text-3xl sm:text-4xl font-serif font-semibold text-[#2B4C3F] mb-2">
            Create New Password
        </h2>
        <p class="text-[#5C6E65] text-sm mb-8 leading-relaxed">
            Please enter your new password below to regain access to your account.
        </p>

        @if(session('error'))
            <div class="mb-6 p-4 bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C] text-sm rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address Input -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                    Email Address
                </label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required readonly
                           class="w-full px-4 py-3 bg-[#EAF2EE] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 placeholder-[#8A9C91]">
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
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                    New Password
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 placeholder-[#8A9C91]"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('password', this)"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#5C6E65] hover:text-[#2B4C3F] focus:outline-none transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <!-- Confirm Password Input -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                    Confirm New Password
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 placeholder-[#8A9C91]"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#5C6E65] hover:text-[#2B4C3F] focus:outline-none transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white py-3.5 px-4 rounded-lg font-semibold text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C3F] focus:ring-offset-2">
                Reset Password
            </button>
        </form>
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
                "Securing your stay, elegantly."
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
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
</script>
@endsection
