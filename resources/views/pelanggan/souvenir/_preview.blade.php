<section class="space-y-10">
    <!-- Header Title & Description -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-gray-200 pb-6">
        <div class="max-w-2xl space-y-3">
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold leading-tight">
                Local Treasures
            </h2>
            <p class="text-sm text-[#5C6E65] leading-relaxed">
                Bawa pulang buah tangan khas hasil karya seni pengrajin lokal terbaik di sekitar Harau.
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

    <!-- Souvenirs Grid (Asymmetrical Layout Reversed) -->
    <div class="flex flex-col md:flex-row gap-8 items-stretch md:items-end">

        <!-- Card 1 (Inactive - Small Card Left) -->
        <div class="w-full md:w-[42%] bg-white rounded-[32px] border border-gray-200/60 shadow-sm p-4 hover:shadow-md transition-all duration-300 group">
            <div class="h-40 sm:h-64 md:h-72 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                <img src="https://images.unsplash.com/photo-1612196808214-b8e1d6145a8c?auto=format&fit=crop&w=800&q=80"
                    alt="Souvenir Secondary"
                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-700 opacity-90 group-hover:opacity-100">
                <!-- Star Rating Badge -->
                <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                    ★ 4.6
                </span>
            </div>
            <div class="pt-5 px-1 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="font-serif font-semibold text-lg text-[#1E362C]">Miniatur Rumah Gadang</h4>
                    <div class="text-right flex items-center gap-1">
                        <span class="font-serif font-semibold text-base text-[#5C6E65]">125.000</span>
                        <span class="text-[10px] text-[#8A9C91] font-medium uppercase">/pcs</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <a href="{{ route('user.souvenir') }}"
                        class="px-6 py-2.5 border border-[#1E362C] text-[#1E362C] hover:bg-[#EAF2EE] text-xs font-semibold rounded-lg transition-all cursor-pointer">
                        Pesan
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 (Active - Large Card Right) -->
        <div class="w-full md:w-[58%] bg-white rounded-[32px] border border-gray-200/60 shadow-sm p-4 hover:shadow-md transition-all duration-300 group">
            <div class="h-48 sm:h-80 md:h-96 overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80"
                    alt="Souvenir Active"
                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-700">
                <!-- Star Rating Badge -->
                <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                    ★ 4.8
                </span>
            </div>
            <div class="pt-5 px-1 space-y-4">
                <div class="flex items-end justify-between">
                    <h4 class="font-serif font-semibold text-xl text-[#1E362C]">Batik Tulis Eksklusif</h4>
                    <div class="text-right">
                        <span class="font-serif font-bold text-xl text-[#1E362C]">350.000</span>
                        <span class="text-xs text-[#8A9C91] font-medium uppercase tracking-wider">/pcs</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <a href="{{ route('user.souvenir') }}"
                        class="px-8 py-3 bg-[#1E362C] hover:bg-[#152720] text-white text-xs font-semibold rounded-lg transition-all shadow-sm cursor-pointer">
                        Pesan
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
