@extends('layouts.user')

@section('title', 'Katalog Souvenir')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-transparent">

        <!-- Hero Section -->
        <div class="text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">Harau Crafts</span>
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold tracking-wide uppercase">
                Local Treasures
            </h2>
            <p class="text-sm text-[#5C6E65] max-w-2xl mx-auto leading-relaxed">
                Bawa pulang buah tangan khas hasil karya seni pengrajin lokal terbaik di sekitar Harau.
            </p>
        </div>

        <!-- Main Catalog Area (Sidebar + Souvenir Grid) -->
        <div class="flex flex-col md:flex-row gap-10 items-start">

            <!-- Left Sidebar: Filter -->
            <div class="w-full md:w-64 flex-shrink-0 space-y-6">
                <h3 class="font-serif text-2xl text-[#2B4C3F] font-semibold tracking-wide border-b border-[#E6E4DD] pb-3">
                    Filter
                </h3>
                <div class="flex flex-col gap-3" id="souvenir-filters">
                    <button data-filter="all"
                        class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-semibold shadow-sm bg-[#EAF2EE] border-[#A7C5B5] text-[#2B4C3F] active-filter-btn">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span>Semua</span>
                    </button>
                    <button data-filter="tersedia"
                        class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Tersedia</span>
                    </button>
                    <button data-filter="habis"
                        class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Habis</span>
                    </button>
                </div>
            </div>

            <!-- Right Content: Souvenir Grid -->
            <div class="flex-grow w-full space-y-6">
                <span class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]"
                    id="souvenir-count-label">
                    Menampilkan {{ $souvenirs->count() }} Souvenir
                </span>

                @if ($souvenirs->isEmpty())
                    <div
                        class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center flex flex-col items-center justify-center shadow-sm">
                        <span class="text-5xl mb-4">🏺</span>
                        <h3 class="text-lg font-serif font-semibold text-[#1E362C] mb-1">Souvenir Belum Tersedia</h3>
                        <p class="text-xs text-[#8A9C91] max-w-sm">
                            Belum ada souvenir yang tersedia saat ini. Silakan kembali beberapa saat lagi!
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="souvenir-grid">
                        @foreach ($souvenirs as $souvenir)
                            @php
                                // Dynamic Star Rating based on souvenir ID for mockup aesthetic
                                $rating = 4.4 + ($souvenir->souvenir_id % 5) * 0.1;
                            @endphp
                            <div class="bg-white rounded-[32px] overflow-hidden border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between p-4 souvenir-card"
                                data-status="{{ strtolower($souvenir->status) }}">
                                <div>
                                    <!-- Image Container -->
                                    <div class="h-60 overflow-hidden relative bg-[#EAF2EE]/50 rounded-2xl">
                                        @if ($souvenir->foto)
                                            <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}"
                                                class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-6xl bg-[#FAF9F6] rounded-2xl">
                                                🏺</div>
                                        @endif

                                        <!-- Status Badge -->
                                        @if ($souvenir->status === 'Tersedia')
                                            <span
                                                class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm border border-gray-200 text-[9px] font-bold uppercase tracking-wider text-[#1E362C] px-2.5 py-1 rounded-full shadow-sm z-10">
                                                Tersedia
                                            </span>
                                        @else
                                            <span
                                                class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-white px-2.5 py-1 rounded-full shadow-sm z-10">
                                                {{ $souvenir->status }}
                                            </span>
                                        @endif

                                        <!-- Rating Badge -->
                                        <span
                                            class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                                            ★ {{ number_format($rating, 1) }}
                                        </span>
                                    </div>

                                    <!-- Souvenir Info -->
                                    <div class="p-4 pt-5 pb-3 space-y-3">
                                        <h4
                                            class="font-serif font-semibold text-xl text-[#1E362C] pb-2 border-b border-gray-100">
                                            {{ $souvenir->nama_souvenir }}
                                        </h4>
                                        @if ($souvenir->detail)
                                            <p class="text-xs text-[#5C6E65] line-clamp-2 leading-relaxed"
                                                title="{{ $souvenir->detail }}">
                                                {{ $souvenir->detail }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price & Action -->
                                <div class="p-4 pt-0">
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                        <div>
                                            <span
                                                class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Harga</span>
                                            <span class="text-base font-bold text-[#1E362C]">Rp
                                                {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[10px] text-[#8A9C91] block">Stok: {{ $souvenir->stok }}
                                                pcs</span>
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
        document.addEventListener('DOMContentLoaded', function() {
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
                btn.addEventListener('click', function() {
                    filters.forEach(f => {
                        f.classList.remove('bg-[#1E362C]', 'border-[#1E362C]', 'text-white',
                            'font-semibold', 'shadow-sm', 'active-filter-btn',
                            'hover:bg-[#152720]', 'hover:text-white');
                        f.classList.add('bg-white', 'border-gray-200', 'text-[#5C6E65]',
                            'font-medium', 'hover:text-[#1E362C]', 'hover:bg-[#EAF2EE]',
                            'hover:border-[#B8DEC8]', 'hover:shadow-sm');
                    });

                    this.classList.remove('bg-white', 'border-gray-200', 'text-[#5C6E65]',
                        'font-medium', 'hover:text-[#1E362C]', 'hover:bg-[#EAF2EE]',
                        'hover:border-[#B8DEC8]', 'hover:shadow-sm');
                    this.classList.add('bg-[#1E362C]', 'border-[#1E362C]', 'text-white',
                        'font-semibold', 'shadow-sm', 'active-filter-btn', 'hover:bg-[#152720]',
                        'hover:text-white');

                    activeFilter = this.getAttribute('data-filter');
                    applyFilters();
                });
            });
        });
    </script>
@endsection
