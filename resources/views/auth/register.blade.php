@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E6E4DD] grid grid-cols-1 md:grid-cols-12">
    
    <!-- Left Side: Image and Quote (Span 5) -->
    <div class="hidden md:block md:col-span-5 relative min-h-[600px] bg-cover bg-center" 
         style="background-image: url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=85');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-[#2B4C3F]/35 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent"></div>
        
        <!-- Content Box -->
        <div class="absolute bottom-12 left-8 right-8 text-white">
            <h3 class="font-serif text-3xl font-semibold mb-4 leading-tight">
                Embrace the rhythm of pause.
            </h3>
            <p class="text-[#FAF9F6] text-sm leading-relaxed opacity-90">
                Join a community dedicated to deliberate living, curated spaces, and the quiet beauty of the everyday.
            </p>
        </div>
    </div>

    <!-- Right Side: Form (Span 7) -->
    <div class="md:col-span-7 p-8 sm:p-12 flex flex-col justify-center bg-[#FAF9F6]/30">
        <h2 class="text-3xl font-serif font-semibold text-[#2B4C3F] mb-2">
            Create Your Aura Account
        </h2>
        <p class="text-[#5C6E65] text-sm mb-8 leading-relaxed">
            Begin your journey towards a more intentional lifestyle.
        </p>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Full Name -->
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Full Name
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200"
                           placeholder="Evelyn Thorne">
                    @error('nama')
                        <p class="mt-1.5 text-xs text-[#9B1C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="sm:col-span-2">
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200"
                           placeholder="evelyn@aura.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-[#9B1C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div class="sm:col-span-2">
                    <label for="no_hp" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Phone Number
                    </label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200"
                           placeholder="081234567890">
                    @error('no_hp')
                        <p class="mt-1.5 text-xs text-[#9B1C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Address
                    </label>
                    <textarea name="alamat" id="alamat" rows="2" required
                              class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200 resize-none"
                              placeholder="Jl. Aura Indah No. 3, Bandung">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1.5 text-xs text-[#9B1C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="col-span-1">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Password
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1.5 text-xs text-[#9B1C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="col-span-1">
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">
                        Confirm
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#D5D3C7] rounded-lg text-sm text-[#2C3E35] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F] focus:border-[#2B4C3F] transition-all duration-200"
                           placeholder="••••••••">
                </div>

            </div>

            <!-- Terms and Conditions Checkbox -->
            <div class="flex items-start mt-4">
                <div class="flex items-center h-5">
                    <input id="terms" type="checkbox" required class="w-4 h-4 text-[#2B4C3F] border-[#D5D3C7] rounded focus:ring-[#2B4C3F]">
                </div>
                <label for="terms" class="ml-2 text-xs text-[#5C6E65] leading-normal cursor-pointer select-none">
                    I agree to the <a href="#" class="font-semibold text-[#2B4C3F] hover:underline">Terms of Service</a> and <a href="#" class="font-semibold text-[#2B4C3F] hover:underline">Privacy Policy</a>.
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white py-3.5 px-4 rounded-lg font-semibold text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C3F] focus:ring-offset-2 mt-2">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-[#5C6E65] mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-[#2B4C3F] hover:underline">Sign In</a>
        </p>
    </div>

</div>
@endsection
