<section class="space-y-10">
    <!-- Header Title & Description -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-gray-200 pb-6">
        <div class="max-w-2xl space-y-3">
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold leading-tight">
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
                class="w-10 h-10 rounded-full border border-[#1E362C]/30 hover:border-[#1E362C] flex items-center justify-center text-[#1E362C] transition-all hover:bg-[#EAF2EE] cursor-pointer"
                aria-label="Previous">
                <span class="text-sm font-bold">&lt;</span>
            </button>
            <button
                class="w-10 h-10 rounded-full border border-[#1E362C]/30 hover:border-[#1E362C] flex items-center justify-center text-[#1E362C] transition-all hover:bg-[#EAF2EE] cursor-pointer"
                aria-label="Next">
                <span class="text-sm font-bold">&gt;</span>
            </button>
        </div>
    </div>

    <!-- Homestay Cards Grid (Asymmetrical Layout) -->
    <div class="flex flex-col md:flex-row gap-8 items-stretch md:items-end">

        <!-- Card 1 (Active - Large Card) -->
        <div class="w-full md:w-[58%] bg-white rounded-[32px] border border-gray-200/60 shadow-sm p-4 hover:shadow-md transition-all duration-300 group">
            <div class="h-48 sm:h-80 md:h-96 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80"
                    alt="Cabin Homestay Active"
                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-700">
                <!-- Star Rating Badge -->
                <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                    ★ 4.9
                </span>
            </div>
            <div class="pt-5 px-1 space-y-4">
                <div class="flex items-end justify-between">
                    <h4 class="font-serif font-semibold text-2xl text-[#1E362C]">Cendana Forest Suite</h4>
                    <div class="text-right">
                        <span class="font-serif font-bold text-xl text-[#1E362C]">900.000</span>
                        <span class="text-xs text-[#8A9C91] font-medium uppercase tracking-wider">/night</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <a href="{{ route('user.homestay') }}"
                        class="px-8 py-3 bg-[#1E362C] hover:bg-[#152720] text-white text-xs font-semibold rounded-full transition-all shadow-sm cursor-pointer">
                        Pesan
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 (Inactive - Small Card) -->
        <div class="w-full md:w-[42%] bg-white rounded-[32px] border border-gray-200/60 shadow-sm p-4 hover:shadow-md transition-all duration-300 group">
            <div class="h-40 sm:h-64 md:h-72 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80"
                    alt="Cabin Homestay Secondary"
                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-700 opacity-90 group-hover:opacity-100">
                <!-- Star Rating Badge -->
                <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                    ★ 4.7
                </span>
            </div>
            <div class="pt-5 px-1 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="font-serif font-semibold text-lg text-[#1E362C]">Jati Deluxe Room</h4>
                    <div class="text-right flex items-center gap-1">
                        <span class="font-serif font-semibold text-base text-[#5C6E65]">900.000</span>
                        <span class="text-[10px] text-[#8A9C91] font-medium uppercase">/night</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <a href="{{ route('user.homestay') }}"
                        class="px-6 py-2.5 border border-[#1E362C] text-[#1E362C] hover:bg-[#EAF2EE] text-xs font-semibold rounded-full transition-all cursor-pointer">
                        Pesan
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
