<section class="space-y-10">
    <!-- Header Title & Description -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-[#E6E4DD] pb-6">
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
