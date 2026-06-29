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

            <form action="{{ route('user.souvenir') }}" method="GET"
                class="max-w-4xl mx-auto bg-white rounded-3xl sm:rounded-full border border-[#E6E4DD] shadow-md p-2 sm:p-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <div class="flex-1 px-5 py-2 border-b sm:border-b-0 sm:border-r border-[#F2F0EA] text-left space-y-0.5">
                    <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8A9C91]">URUTKAN</span>
                    <select name="kategori"
                        class="w-full bg-transparent text-sm font-medium text-[#2B4C3F] border-0 p-0 focus:ring-0">
                        <option value="" @selected($kategori !== 'terlaris')>Terbaru</option>
                        <option value="terlaris" @selected($kategori === 'terlaris')>Terlaris</option>
                    </select>
                </div>

                <div class="flex-1 px-5 py-2 text-left space-y-0.5">
                    <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8A9C91]">STATUS</span>
                    <select name="status"
                        class="w-full bg-transparent text-sm font-medium text-[#2B4C3F] border-0 p-0 focus:ring-0">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $statusOption)
                            <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusOption }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-[#2B4C3F] hover:bg-[#1E362C] text-white font-semibold rounded-2xl sm:rounded-full px-6 py-3 flex items-center justify-center gap-2 shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="text-xs uppercase tracking-widest">Filter</span>
                    </button>
                    <a href="{{ route('user.souvenir') }}"
                        class="bg-[#FAF9F6] hover:bg-[#F2F0EA] text-[#5C6E65] font-semibold rounded-2xl sm:rounded-full px-5 py-3 flex items-center justify-center text-xs uppercase tracking-widest border border-[#E6E4DD] transition-all">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Catalog Area (Sidebar + Souvenir Grid) -->
        <div class="flex flex-col md:flex-row gap-10 items-start">

            <!-- Left Sidebar: Filter & Sort -->
            <div class="w-full md:w-64 flex-shrink-0 space-y-8">
                <!-- Urutan Section -->
                <div class="space-y-4">
                    <h3
                        class="font-serif text-2xl text-[#2B4C3F] font-semibold tracking-wide border-b border-[#E6E4DD] pb-3">
                        Urutkan
                    </h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('user.souvenir', array_filter(['status' => $status])) }}"
                            class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium shadow-sm {{ $kategori !== 'terlaris' ? 'bg-[#EAF2EE] border-[#A7C5B5] text-[#2B4C3F] font-semibold' : 'bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Terbaru</span>
                        </a>
                        <a href="{{ route('user.souvenir', array_filter(['kategori' => 'terlaris', 'status' => $status])) }}"
                            class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium shadow-sm {{ $kategori === 'terlaris' ? 'bg-[#EAF2EE] border-[#A7C5B5] text-[#2B4C3F] font-semibold' : 'bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z">
                                </path>
                            </svg>
                            <span>Terlaris</span>
                        </a>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="space-y-4">
                    <h3
                        class="font-serif text-2xl text-[#2B4C3F] font-semibold tracking-wide border-b border-[#E6E4DD] pb-3">
                        Status
                    </h3>
                    <div class="flex flex-col gap-3" id="souvenir-filters">
                        <button data-filter="all"
                            class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm">
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
            </div>

            <!-- Right Content: Souvenir Grid -->
            <div class="flex-grow w-full space-y-6">
                <span class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]"
                    id="souvenir-count-label">
                    Menampilkan {{ $souvenirs->count() }} Souvenir
                </span>

                @if ($souvenirs->isEmpty())
                    <div
                        class="bg-white rounded-3xl border border-[#E6E4DD] p-12 text-center flex flex-col items-center justify-center shadow-sm">
                        <span class="text-5xl mb-4">🏺</span>
                        <h3 class="text-lg font-serif font-semibold text-[#2C3E35] mb-1">Souvenir Belum Tersedia</h3>
                        <p class="text-xs text-[#8A9C91] max-w-sm">
                            Belum ada souvenir yang tersedia saat ini. Silakan kembali beberapa saat lagi!
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="souvenir-grid">
                        @foreach ($souvenirs as $souvenir)
                            <div class="bg-white rounded-3xl overflow-hidden border border-[#E6E4DD]/60 shadow-sm hover:shadow-md hover:border-[#A7C5B5]/30 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between souvenir-card"
                                data-status="{{ strtolower($souvenir->status) }}">
                                <div>
                                    <!-- Image Container -->
                                    <div class="h-60 overflow-hidden relative bg-[#EAF2EE]/50">
                                        @if ($souvenir->foto)
                                            <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-6xl bg-[#FAF9F6]">
                                                🏺</div>
                                        @endif
                                        @if ($souvenir->status === 'Tersedia')
                                            <span
                                                class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm border border-[#A7C5B5]/20 text-[9px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">
                                                Tersedia
                                            </span>
                                        @else
                                            <span
                                                class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-white px-3 py-1.5 rounded-full shadow-sm">
                                                {{ $souvenir->status }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Souvenir Info -->
                                    <div class="p-6 space-y-3">
                                        <h4
                                            class="font-serif font-semibold text-xl text-[#2C3E35] pb-2.5 border-b border-[#F0EDE6]">
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
                                <div class="p-6 pt-0">
                                    <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4 mb-4">
                                        <div>
                                            <span
                                                class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Harga</span>
                                            <span class="text-base font-semibold text-[#2B4C3F]">Rp
                                                {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="text-right space-y-0.5">
                                            <span class="text-[10px] text-[#8A9C91] block">Stok: {{ $souvenir->stok }}
                                                pcs</span>
                                            <span class="text-[10px] text-[#5C6E65] font-medium block">
                                                <span
                                                    class="inline-block w-1.5 h-1.5 rounded-full bg-[#E9C46A] mr-1"></span>{{ $souvenir->jumlah_terjual }}
                                                terjual
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('user.souvenir.show', $souvenir->souvenir_id) }}"
                                        class="w-full py-2.5 rounded-2xl border border-[#A7C5B5] text-[#2B4C3F] text-xs font-semibold tracking-wide bg-[#EAF2EE] hover:bg-[#2B4C3F] hover:text-white transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Lihat Detail
                                    </a>

                                    @if ($souvenir->status === 'Tersedia' && $souvenir->stok > 0)
                                        <div class="mt-4 pt-4 border-t border-[#F2F0EA]">
                                            <button type="button"
                                                onclick="openAddToCartModal('{{ $souvenir->souvenir_id }}', '{{ addslashes($souvenir->nama_souvenir) }}', {{ $souvenir->stok }}, '{{ $souvenir->foto ? asset($souvenir->foto) : '' }}')"
                                                class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold py-2.5 px-4 rounded-xl shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                <span>Tambah ke Keranjang</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="mt-4 pt-4 border-t border-[#F2F0EA]">
                                            <button disabled
                                                class="w-full bg-gray-100 text-gray-400 text-xs font-semibold py-2.5 px-4 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                                <span>Stok Habis / Tidak Tersedia</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add to Cart Modal -->
    <div id="addToCartModal"
        class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-[#1E362C]/60 backdrop-blur-sm" onclick="closeAddToCartModal()"></div>
        <div class="bg-white w-full max-w-sm rounded-3xl p-6 relative z-10 shadow-xl transform scale-95 transition-transform duration-300"
            id="addToCartModalContent">

            <button type="button" onclick="closeAddToCartModal()"
                class="absolute top-4 right-4 p-2 text-[#8A9C91] hover:text-[#E65F5F] hover:bg-[#FDF2F2] rounded-full transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <h3 class="font-serif text-xl font-semibold text-[#2C3E35] mb-6">Tambah ke Keranjang</h3>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="souvenir_id" id="modal_souvenir_id">

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40"
                        id="modal_image_container">
                        <img src="" alt="" id="modal_souvenir_image"
                            class="w-full h-full object-cover hidden">
                        <div id="modal_souvenir_no_image"
                            class="w-full h-full flex items-center justify-center text-2xl bg-[#FAF9F6] hidden">🏺</div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#2C3E35] leading-tight" id="modal_souvenir_name">Nama Souvenir</h4>
                        <span class="text-[10px] text-[#8A9C91] block mt-1">Stok tersedia: <span
                                id="modal_souvenir_stock">0</span> pcs</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8 border border-[#E6E4DD] rounded-xl p-2 bg-[#FAF9F6]">
                    <span class="px-3 text-sm font-semibold text-[#5C6E65]">Kuantitas</span>
                    <div class="flex items-center gap-3 pr-1">
                        <button type="button" onclick="decrementQuantity()"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-[#E6E4DD] text-[#2C3E35] hover:bg-[#EAF2EE] hover:border-[#A7C5B5] transition-colors shadow-sm focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                </path>
                            </svg>
                        </button>

                        <input type="number" name="quantity" id="modal_quantity" value="1" min="1"
                            readonly
                            class="w-8 text-center bg-transparent border-none focus:ring-0 text-[#2C3E35] font-bold text-lg p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">

                        <button type="button" onclick="incrementQuantity()"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-[#E6E4DD] text-[#2C3E35] hover:bg-[#EAF2EE] hover:border-[#A7C5B5] transition-colors shadow-sm focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3.5 px-4 rounded-xl shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                    <span>Konfirmasi Tambah</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Javascript untuk Filtering & Modal -->
    <script>
        let maxStock = 1;

        window.openAddToCartModal = function(id, name, stock, imageUrl) {
            maxStock = parseInt(stock);

            document.getElementById('modal_souvenir_id').value = id;
            document.getElementById('modal_souvenir_name').textContent = name;
            document.getElementById('modal_souvenir_stock').textContent = stock;
            document.getElementById('modal_quantity').value = 1;

            const imgEl = document.getElementById('modal_souvenir_image');
            const noImgEl = document.getElementById('modal_souvenir_no_image');

            if (imageUrl && imageUrl.trim() !== '') {
                imgEl.src = imageUrl;
                imgEl.classList.remove('hidden');
                noImgEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                noImgEl.classList.remove('hidden');
            }

            const modal = document.getElementById('addToCartModal');
            const modalContent = document.getElementById('addToCartModalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        window.closeAddToCartModal = function() {
            const modal = document.getElementById('addToCartModal');
            const modalContent = document.getElementById('addToCartModalContent');

            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        window.incrementQuantity = function() {
            const qtyInput = document.getElementById('modal_quantity');
            let val = parseInt(qtyInput.value);
            if (val < maxStock) {
                qtyInput.value = val + 1;
            }
        }

        window.decrementQuantity = function() {
            const qtyInput = document.getElementById('modal_quantity');
            let val = parseInt(qtyInput.value);
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        }

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
                        f.classList.remove('bg-[#EAF2EE]', 'border-[#A7C5B5]',
                            'text-[#2B4C3F]', 'font-semibold', 'shadow-sm',
                            'active-filter-btn');
                        f.classList.add('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]',
                            'font-medium');
                    });

                    this.classList.remove('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]',
                        'font-medium');
                    this.classList.add('bg-[#EAF2EE]', 'border-[#A7C5B5]', 'text-[#2B4C3F]',
                        'font-semibold', 'shadow-sm', 'active-filter-btn');

                    activeFilter = this.getAttribute('data-filter');
                    applyFilters();
                });
            });
        });
    </script>
@endsection
