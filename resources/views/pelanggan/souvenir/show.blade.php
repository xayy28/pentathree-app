@extends('layouts.user')

@section('title', $souvenir->nama_souvenir)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#8A9C91]">
        <a href="{{ route('user.souvenir') }}" class="hover:text-[#2B4C3F] transition-colors flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Katalog Souvenir
        </a>
        <span class="text-[#D1D5DB]">/</span>
        <span class="text-[#2B4C3F] font-medium truncate max-w-[200px]">{{ $souvenir->nama_souvenir }}</span>
    </nav>

    {{-- Main Detail Section --}}
    <div class="flex flex-col lg:flex-row gap-10 items-start">

        {{-- ===== KIRI: Foto & Galeri ===== --}}
        <div class="w-full lg:w-[55%] space-y-4">
            {{-- Foto Utama --}}
            <div class="relative rounded-[32px] overflow-hidden bg-[#EAF2EE]/50 aspect-[4/3]">
                @if($souvenir->foto)
                    <img
                        id="main-photo"
                        src="{{ asset($souvenir->foto) }}"
                        alt="{{ $souvenir->nama_souvenir }}"
                        class="w-full h-full object-cover transition-opacity duration-300"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center text-8xl bg-[#F8F7F4]" id="main-photo-placeholder">🏺</div>
                @endif

                {{-- Status Badge --}}
                @if($souvenir->status === 'Tersedia')
                    <span class="absolute top-5 left-5 bg-white/95 backdrop-blur-sm border border-[#A7C5B5]/30 text-[9px] font-bold uppercase tracking-wider text-[#2B4C3F] px-3 py-1.5 rounded-full shadow-sm">
                        ✓ Tersedia
                    </span>
                @else
                    <span class="absolute top-5 left-5 bg-[#E65F5F]/90 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-white px-3 py-1.5 rounded-full shadow-sm">
                        {{ $souvenir->status }}
                    </span>
                @endif

                {{-- Sold badge --}}
                @if($souvenir->jumlah_terjual > 0)
                    <span class="absolute top-5 right-5 bg-[#E9C46A]/90 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-[#1E362C] px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                        🔥 {{ $souvenir->jumlah_terjual }}x terjual
                    </span>
                @endif
            </div>

            {{-- Thumbnail strip --}}
            @if($souvenir->foto)
                <div class="flex gap-3">
                    {{-- Foto asli --}}
                    <button
                        onclick="setMainPhoto('{{ asset($souvenir->foto) }}')"
                        class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-[#2B4C3F] flex-shrink-0 transition-all hover:opacity-90 active-thumb"
                    >
                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover">
                    </button>
                    {{-- Placeholder view dari sudut lain --}}
                    <button
                        onclick="setMainPhoto('{{ asset($souvenir->foto) }}')"
                        class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-transparent hover:border-[#A7C5B5] flex-shrink-0 transition-all relative"
                    >
                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover brightness-90 hover:brightness-100 transition-all" style="object-position: center 20%">
                        <span class="absolute inset-0 bg-[#1E362C]/10 hover:bg-transparent transition-all rounded-xl"></span>
                    </button>
                    <button
                        onclick="setMainPhoto('{{ asset($souvenir->foto) }}')"
                        class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-transparent hover:border-[#A7C5B5] flex-shrink-0 transition-all relative"
                    >
                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover brightness-95 hover:brightness-100 transition-all" style="object-position: center 80%">
                        <span class="absolute inset-0 bg-[#1E362C]/15 hover:bg-transparent transition-all rounded-xl"></span>
                    </button>
                </div>
            @endif
        </div>

        {{-- ===== KANAN: Info & Aksi ===== --}}
        <div class="w-full lg:w-[45%] space-y-6">

            {{-- Nama & Label --}}
            <div class="space-y-2">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#8A9C91]">Natasha Retreat · Souvenir Lokal</span>
                <h1 class="font-serif text-3xl sm:text-4xl font-semibold text-[#2B4C3F] leading-tight">
                    {{ $souvenir->nama_souvenir }}
                </h1>
            </div>

            {{-- Harga --}}
            <div class="flex items-end gap-3 py-4 border-y border-[#E6E4DD]">
                <div>
                    <span class="text-[9px] text-[#8A9C91] uppercase tracking-widest block mb-0.5">Harga Satuan</span>
                    <span class="font-serif text-3xl font-bold text-[#2B4C3F]">
                        Rp {{ number_format($souvenir->harga, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-[#8A9C91] ml-1">/ pcs</span>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-[#F8F7F4] rounded-2xl p-4 text-center border border-[#E6E4DD]">
                    <span class="text-2xl block mb-1">📦</span>
                    <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Stok</span>
                    <span class="text-base font-bold text-[#2B4C3F]">{{ $souvenir->stok }}</span>
                    <span class="text-[9px] text-[#8A9C91]"> pcs</span>
                </div>
                <div class="bg-[#EAF2EE] rounded-2xl p-4 text-center border border-[#A7C5B5]/40">
                    <span class="text-2xl block mb-1">🔥</span>
                    <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Terjual</span>
                    <span class="text-base font-bold text-[#2B4C3F]">{{ $souvenir->jumlah_terjual }}</span>
                    <span class="text-[9px] text-[#5C6E65]"> pcs</span>
                </div>
                <div class="bg-[#F8F7F4] rounded-2xl p-4 text-center border border-[#E6E4DD]">
                    <span class="text-2xl block mb-1">✅</span>
                    <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Status</span>
                    <span class="text-xs font-bold {{ $souvenir->status === 'Tersedia' ? 'text-[#2B4C3F]' : 'text-[#E65F5F]' }}">
                        {{ $souvenir->status }}
                    </span>
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($souvenir->detail)
                <div class="space-y-2">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Deskripsi Produk</h3>
                    <p class="text-sm text-[#5C6E65] leading-relaxed">
                        {{ $souvenir->detail }}
                    </p>
                </div>
            @endif

            {{-- Info Tambahan --}}
            <div class="space-y-2.5 py-4 border-t border-[#E6E4DD]">
                <div class="flex items-center gap-3 text-xs text-[#5C6E65]">
                    <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Produk lokal dari pengrajin Lembah Harau, Payakumbuh
                </div>
                <div class="flex items-center gap-3 text-xs text-[#5C6E65]">
                    <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Terakhir diperbarui: {{ $souvenir->updated_at ? $souvenir->updated_at->diffForHumans() : '-' }}
                </div>
                <div class="flex items-center gap-3 text-xs text-[#5C6E65]">
                    <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Kualitas terjamin · Produk autentik
                </div>
            </div>

            {{-- Tombol Aksi --}}
            @if($souvenir->status === 'Tersedia' && $souvenir->stok > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    <input type="hidden" name="souvenir_id" value="{{ $souvenir->souvenir_id }}">

                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-[#E6E4DD] bg-[#FAF9F6] p-3">
                        <span class="text-sm font-semibold text-[#5C6E65]">Kuantitas</span>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decrementDetailQuantity()"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-[#E6E4DD] text-[#2C3E35] hover:bg-[#EAF2EE] hover:border-[#A7C5B5] transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="detail_quantity" value="1" min="1"
                                max="{{ $souvenir->stok }}"
                                class="w-14 text-center bg-white border border-[#E6E4DD] rounded-xl focus:ring-[#A7C5B5] focus:border-[#A7C5B5] text-[#2C3E35] font-bold py-2">
                            <button type="button" onclick="incrementDetailQuantity()"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-[#E6E4DD] text-[#2C3E35] hover:bg-[#EAF2EE] hover:border-[#A7C5B5] transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" name="redirect_to" value="checkout"
                            class="flex-1 py-4 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-2xl transition-all shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Pesan Sekarang
                        </button>
                        <button type="submit" name="redirect_to" value="cart"
                            class="flex-1 py-4 border border-[#A7C5B5] text-[#2B4C3F] hover:bg-[#EAF2EE] text-sm font-semibold rounded-2xl transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Tambahkan ke Keranjang
                        </button>
                    </div>
                </form>
            @else
                <div class="space-y-3 pt-2">
                    <button disabled class="w-full py-4 bg-[#F3F4F6] border border-[#E6E4DD] text-[#8A9C91] text-sm font-semibold rounded-2xl cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Stok Habis
                    </button>
                    <a href="{{ route('user.souvenir') }}" class="w-full py-3 border border-[#A7C5B5] text-[#2B4C3F] hover:bg-[#EAF2EE] text-sm font-semibold rounded-2xl transition-all flex items-center justify-center gap-2">
                        Lihat Souvenir Lainnya
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- ===== Rekomendasi Souvenir Lain ===== --}}
    @if($rekomendasi->isNotEmpty())
        <div class="space-y-6 pt-4 border-t border-[#E6E4DD]">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">Mungkin kamu suka</span>
                    <h2 class="font-serif text-2xl font-semibold text-[#2B4C3F]">Souvenir Lainnya</h2>
                </div>
                <a href="{{ route('user.souvenir') }}" class="text-xs font-semibold text-[#2B4C3F] hover:underline flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($rekomendasi as $item)
                    <a href="{{ route('user.souvenir.show', $item->souvenir_id) }}"
                       class="bg-white rounded-[28px] overflow-hidden border border-[#E6E4DD]/60 shadow-sm hover:shadow-md hover:border-[#A7C5B5]/40 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col">
                        <div class="h-44 overflow-hidden relative bg-[#EAF2EE]/30">
                            @if($item->foto)
                                <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_souvenir }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl bg-[#FAF9F6]">🏺</div>
                            @endif
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <h4 class="font-serif font-semibold text-[#2B4C3F] text-base mb-1">{{ $item->nama_souvenir }}</h4>
                                @if($item->detail)
                                    <p class="text-xs text-[#8A9C91] line-clamp-2 leading-relaxed">{{ $item->detail }}</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-[#F2F0EA]">
                                <span class="text-sm font-bold text-[#2B4C3F]">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-semibold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1 rounded-full">Lihat →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function setMainPhoto(url) {
        const img = document.getElementById('main-photo');
        if (img) {
            img.src = url;
        }
    }

    function pesanSekarang() {
        // Placeholder — sambungkan ke halaman checkout/keranjang saat sudah siap
        alert('Fitur pemesanan segera hadir!');
    }

    function tambahKeKeranjang(btn) {
        // Ubah tampilan tombol sementara
        const original = btn.innerHTML;
        btn.innerHTML = `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Ditambahkan!
        `;
        btn.classList.add('bg-[#EAF2EE]', 'border-[#2B4C3F]');
        btn.disabled = true;

        // Tampilkan toast
        const toast = document.getElementById('toast-keranjang');
        toast.classList.remove('hidden');
        toast.classList.add('flex');

        // Reset setelah 2.5 detik
        setTimeout(() => {
            btn.innerHTML = original;
            btn.classList.remove('bg-[#EAF2EE]', 'border-[#2B4C3F]');
            btn.disabled = false;
            toast.classList.remove('flex');
            toast.classList.add('hidden');
        }, 2500);
    }
</script>
@endsection
