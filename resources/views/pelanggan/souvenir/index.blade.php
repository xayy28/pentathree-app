@extends('layouts.user')

@section('title', 'Katalog Souvenir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-[#F8F7F4]">

    <!-- Hero Section -->
    <div class="text-center space-y-6">
        <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
            Local Treasures
        </h2>
        <p class="text-sm text-[#5C6E65] max-w-2xl mx-auto leading-relaxed">
            Bawa pulang buah tangan khas hasil karya seni pengrajin lokal terbaik di sekitar Harau.
        </p>
    </div>

    <!-- Main Catalog Area (Sidebar + Souvenir Grid) -->
    <div class="flex flex-col md:flex-row gap-10 items-start">

        <!-- Left Sidebar: Filter -->
        <div class="w-full md:w-64 flex-shrink-0 md:space-y-6">
            <h3 class="hidden md:block font-serif text-2xl text-[#2B4C3F] font-semibold tracking-wide border-b border-[#E6E4DD] pb-3">
                Filter
            </h3>
            <div class="flex flex-row md:flex-col gap-3 overflow-x-auto pb-3 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-none" id="souvenir-filters">
                <button data-filter="all" class="flex items-center justify-center md:justify-start gap-2 md:gap-4 w-auto md:w-full px-4 md:px-5 py-2.5 md:py-4 rounded-xl md:rounded-2xl border transition-all text-center md:text-left font-semibold shadow-sm bg-[#EAF2EE] border-[#A7C5B5] text-[#2B4C3F] active-filter-btn whitespace-nowrap">
                    <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>Semua</span>
                </button>
                <button data-filter="tersedia" class="flex items-center justify-center md:justify-start gap-2 md:gap-4 w-auto md:w-full px-4 md:px-5 py-2.5 md:py-4 rounded-xl md:rounded-2xl border transition-all text-center md:text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Tersedia</span>
                </button>
                <button data-filter="habis" class="flex items-center justify-center md:justify-start gap-2 md:gap-4 w-auto md:w-full px-4 md:px-5 py-2.5 md:py-4 rounded-xl md:rounded-2xl border transition-all text-center md:text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Habis</span>
                </button>
            </div>
        </div>

        <!-- Right Content: Souvenir Grid -->
        <div class="flex-grow w-full space-y-6">
            <span class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]" id="souvenir-count-label">
                Menampilkan {{ $souvenirs->count() }} Souvenir
            </span>

            @if($souvenirs->isEmpty())
                <div class="bg-white rounded-3xl border border-[#E6E4DD] p-12 text-center flex flex-col items-center justify-center shadow-sm">
                    <span class="text-5xl mb-4">🏺</span>
                    <h3 class="text-lg font-serif font-semibold text-[#2C3E35] mb-1">Souvenir Belum Tersedia</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm">
                        Belum ada souvenir yang tersedia saat ini. Silakan kembali beberapa saat lagi!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="souvenir-grid">
                    @foreach($souvenirs as $souvenir)
                        <div class="bg-white rounded-3xl overflow-hidden border border-[#E6E4DD]/60 shadow-sm hover:shadow-md hover:border-[#A7C5B5]/30 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between souvenir-card" data-status="{{ strtolower($souvenir->status) }}">
                            <div>
                                <!-- Image Container -->
                                <div class="h-60 overflow-hidden relative bg-[#EAF2EE]/50">
                                    @if($souvenir->foto)
                                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-6xl bg-[#FAF9F6]">🏺</div>
                                    @endif
                                    @if($souvenir->status === 'Tersedia')
                                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm border border-[#A7C5B5]/20 text-[9px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-white px-3 py-1.5 rounded-full shadow-sm">
                                            {{ $souvenir->status }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Souvenir Info -->
                                <div class="p-4 sm:p-6 space-y-3">
                                    <h4 class="font-serif font-semibold text-xl text-[#2C3E35] pb-2.5 border-b border-[#F0EDE6]">
                                        {{ $souvenir->nama_souvenir }}
                                    </h4>
                                    @if($souvenir->detail)
                                        <p class="text-xs text-[#5C6E65] line-clamp-2 leading-relaxed" title="{{ $souvenir->detail }}">
                                            {{ $souvenir->detail }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Price & Action -->
                            <div class="p-4 sm:p-6 pt-0">
                                <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                                    <div>
                                        <span class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Harga</span>
                                        <span class="text-base font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] text-[#8A9C91] block">Stok: {{ $souvenir->stok }} pcs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Javascript untuk Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filters = document.querySelectorAll('#souvenir-filters button');
        const cards = document.querySelectorAll('.souvenir-card');
        const label = document.getElementById('souvenir-count-label');

        let activeFilter = 'all';

        function applyFilters() {
            let visibleCount = 0;
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const matches = (activeFilter === 'all' || cardStatus === activeFilter);

                if (matches) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (label) {
                label.textContent = `Menampilkan ${visibleCount} Souvenir`;
            }
        }

        filters.forEach(btn => {
            btn.addEventListener('click', function () {
                filters.forEach(f => {
                    f.classList.remove('bg-[#EAF2EE]', 'border-[#A7C5B5]', 'text-[#2B4C3F]', 'font-semibold', 'shadow-sm', 'active-filter-btn');
                    f.classList.add('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]', 'font-medium');
                });

                this.classList.remove('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]', 'font-medium');
                this.classList.add('bg-[#EAF2EE]', 'border-[#A7C5B5]', 'text-[#2B4C3F]', 'font-semibold', 'shadow-sm', 'active-filter-btn');

                activeFilter = this.getAttribute('data-filter');
                applyFilters();
            });
        });
    });
</script>
@endsection
