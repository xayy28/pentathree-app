@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero Section (Seamless with navbar) -->
    <div class="relative h-[450px] sm:h-[550px] bg-cover bg-center flex items-center justify-center -mt-6 sm:-mt-0"
        style="background-image: url('{{ asset('images/hero-banner1.png') }}');">
        <!-- Dark overlay to ensure text contrast -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Hero Text Content -->
        <div class="relative z-10 text-center text-white px-4 max-w-3xl space-y-4">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.25em] uppercase block drop-shadow-sm text-white/90">
                The Art of Retreat
            </span>
            <h1 class="font-cursive text-5xl sm:text-6xl md:text-7xl font-bold leading-tight drop-shadow-md">
                Quiet spaces for intentional living.
            </h1>
        </div>
    </div>

    <!-- Main Page Container (Cream Background) -->
    <div class="bg-[#F8F7F4] py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            <!-- Section 1: Our Curated Sanctuaries (Homestays) -->
            <section class="space-y-10">
                <!-- Header Title & Description -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-[#E6E4DD] pb-6">
                    <div class="max-w-2xl space-y-3">
                        <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold leading-tight">
                            Our Curated Sanctuaries
                        </h2>
                        <p class="text-sm text-[#5C6E65] leading-relaxed">
                            Each home is selected for its architectural honesty, connection to the Harau landscape, and
                            commitment to quiet hospitality.
                        </p>
                    </div>
                    <!-- Navigation Arrows -->
                    <div class="flex gap-3">
                        <button
                            class="w-10 h-10 rounded-full border border-[#2B4C3F]/30 hover:border-[#2B4C3F] flex items-center justify-center text-[#2B4C3F] transition-all hover:bg-[#EAF2EE]"
                            aria-label="Previous">
                            <span class="text-sm font-bold">&lt;</span>
                        </button>
                        <button
                            class="w-10 h-10 rounded-full border border-[#2B4C3F]/30 hover:border-[#2B4C3F] flex items-center justify-center text-[#2B4C3F] transition-all hover:bg-[#EAF2EE]"
                            aria-label="Next">
                            <span class="text-sm font-bold">&gt;</span>
                        </button>
                    </div>
                </div>

                <!-- Homestay Cards Grid (Asymmetrical Layout) -->
                <div class="flex flex-col md:flex-row gap-8 items-end">

                    <!-- Card 1 (Active - Large Card) -->
                    <div class="w-full md:w-[58%] transition-all duration-300 group">
                        <div class="h-80 sm:h-96 overflow-hidden rounded-[32px] relative bg-[#EAF2EE]/10">
                            <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80"
                                alt="Cabin Homestay Active"
                                class="w-full h-full object-cover rounded-[32px] group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="pt-5 px-1 space-y-4">
                            <div class="flex items-end justify-between">
                                <h4 class="font-serif font-semibold text-2xl text-[#2C3E35]">Kamar 1</h4>
                                <div class="text-right">
                                    <span class="font-serif font-bold text-xl text-[#2B4C3F]">900.000</span>
                                    <span class="text-xs text-[#8A9C91] font-medium uppercase tracking-wider">/night</span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <a href="{{ route('user.homestay') }}"
                                    class="px-8 py-3 bg-[#1E362C] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-full transition-all shadow-sm">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 (Inactive - Small Card) -->
                    <div class="w-full md:w-[42%] transition-all duration-300 group">
                        <div class="h-64 sm:h-72 overflow-hidden rounded-[32px] relative bg-[#EAF2EE]/10">
                            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80"
                                alt="Cabin Homestay Secondary"
                                class="w-full h-full object-cover rounded-[32px] group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100">
                        </div>
                        <div class="pt-5 px-1 space-y-4">
                            <div class="flex items-center justify-between">
                                <h4 class="font-serif font-semibold text-lg text-[#2C3E35]">Kamar 1</h4>
                                <div class="text-right flex items-center gap-1">
                                    <span class="font-serif font-semibold text-base text-[#5C6E65]">900.000</span>
                                    <span class="text-[10px] text-[#8A9C91] font-medium uppercase">/night</span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <a href="{{ route('user.homestay') }}"
                                    class="px-6 py-2.5 border border-[#2B4C3F] text-[#2B4C3F] hover:bg-[#EAF2EE] text-xs font-semibold rounded-full transition-all">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Section 2: Local Treasures (Souvenirs) -->
            <section class="space-y-10">
                <!-- Header Title & Description -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-[#E6E4DD] pb-6">
                    <div class="max-w-2xl space-y-3">
                        <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold leading-tight">
                            Local Treasures
                        </h2>
                        <p class="text-sm text-[#5C6E65] leading-relaxed">
                            Bawa pulang buah tangan khas hasil karya seni pengrajin lokal terbaik di sekitar Harau.
                        </p>
                    </div>
                    <!-- Navigation Arrows -->
                    <div class="flex gap-3">
                        <button
                            class="w-10 h-10 rounded-full border border-[#2B4C3F]/30 hover:border-[#2B4C3F] flex items-center justify-center text-[#2B4C3F] transition-all hover:bg-[#EAF2EE]"
                            aria-label="Previous">
                            <span class="text-sm font-bold">&lt;</span>
                        </button>
                        <button
                            class="w-10 h-10 rounded-full border border-[#2B4C3F]/30 hover:border-[#2B4C3F] flex items-center justify-center text-[#2B4C3F] transition-all hover:bg-[#EAF2EE]"
                            aria-label="Next">
                            <span class="text-sm font-bold">&gt;</span>
                        </button>
                    </div>
                </div>

                <!-- Souvenirs Grid (Asymmetrical Layout Reversed) -->
                <div class="flex flex-col md:flex-row gap-8 items-end">

                    <!-- Card 1 (Inactive - Small Card Left) -->
                    <div class="w-full md:w-[42%] transition-all duration-300 group">
                        <div class="h-64 sm:h-72 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                            <img src="https://images.unsplash.com/photo-1612196808214-b8e1d6145a8c?auto=format&fit=crop&w=800&q=80"
                                alt="Souvenir Secondary"
                                class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100">
                        </div>
                        <div class="pt-5 px-1 space-y-4">
                            <div class="flex items-center justify-between">
                                <h4 class="font-serif font-semibold text-lg text-[#2C3E35]">Souvenir 2</h4>
                                <div class="text-right flex items-center gap-1">
                                    <span class="font-serif font-semibold text-base text-[#5C6E65]">900.000</span>
                                    <span class="text-[10px] text-[#8A9C91] font-medium uppercase">/night</span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <a href="{{ route('user.souvenir') }}"
                                    class="px-6 py-2.5 border border-[#2B4C3F] text-[#2B4C3F] hover:bg-[#EAF2EE] text-xs font-semibold rounded-lg transition-all">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 (Active - Large Card Right) -->
                    <div class="w-full md:w-[58%] transition-all duration-300 group">
                        <div class="h-80 sm:h-96 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                            <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80"
                                alt="Souvenir Active"
                                class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="pt-5 px-1 space-y-4">
                            <div class="flex items-end justify-between">
                                <h4 class="font-serif font-semibold text-xl text-[#2C3E35]">Souvenir 1</h4>
                                <div class="text-right">
                                    <span class="font-serif font-bold text-xl text-[#2B4C3F]">10.000</span>
                                    <span class="text-xs text-[#8A9C91] font-medium uppercase tracking-wider">/pcs</span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <a href="{{ route('user.souvenir') }}"
                                    class="px-8 py-3 bg-[#1E362C] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-all shadow-sm">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Section 3: Quote filosofis (Bottom) -->
            <section class="flex justify-center pt-8">
                <div
                    class="w-full max-w-4xl bg-[#F0EDE4] rounded-[40px] px-8 py-16 sm:px-16 sm:py-20 text-center space-y-6 shadow-sm border border-[#E6E4DD]/40 relative overflow-hidden">
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
