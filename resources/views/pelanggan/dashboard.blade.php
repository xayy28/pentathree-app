@extends('layouts.user')

@section('title', 'Explore')

@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="relative h-[88vh] min-h-[560px] max-h-[780px] overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/hero-banner1.png') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#0d1f18]/70 via-[#1E362C]/50 to-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#F3F4F6] via-transparent to-transparent" style="background: linear-gradient(to top, #F3F4F6 0%, transparent 35%)"></div>
    </div>

    {{-- Greeting pill --}}
    <div class="absolute top-6 right-6 sm:top-8 sm:right-8 z-20">
        <div class="flex items-center gap-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full pl-1 pr-4 py-1 shadow-lg">
            @if (auth()->user()->foto_profil)
                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-white/40" alt="">
            @else
                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                </div>
            @endif
            <span class="text-white text-xs font-medium">Halo, {{ explode(' ', auth()->user()->nama)[0] }} 👋</span>
        </div>
    </div>

    {{-- Main content --}}
    <div class="relative z-10 h-full flex flex-col justify-end pb-20 sm:pb-24 px-4 sm:px-8 lg:px-16 max-w-7xl mx-auto">
        <div class="max-w-2xl space-y-5">
            <div class="flex items-center gap-2">
                <div class="h-px w-8 bg-[#A7C5B5]"></div>
                <span class="text-[10px] font-bold tracking-[0.35em] uppercase text-[#A7C5B5]">Natasha Retreat · Lembah Harau</span>
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-semibold text-white leading-[1.1] tracking-tight">
                Temukan Ketenangan<br>
                <span class="text-[#A7C5B5]">di Alam Lembah Harau</span>
            </h1>
            <p class="text-white/70 text-sm sm:text-base leading-relaxed max-w-lg">
                Homestay autentik dan souvenir khas lokal — satu tempat untuk semua pengalaman terbaik kamu.
            </p>
            <div class="flex flex-wrap gap-3 pt-1">
                <a href="{{ route('user.homestay') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#1E362C] text-xs font-bold uppercase tracking-widest rounded-full hover:bg-[#EAF2EE] transition-all shadow-xl">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Booking Homestay
                </a>
                <a href="{{ route('user.souvenir') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-transparent border border-white/40 text-white text-xs font-bold uppercase tracking-widest rounded-full hover:bg-white/10 backdrop-blur-sm transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Lihat Souvenir
                </a>
            </div>
        </div>
    </div>

</section>

{{-- ═══════════════ STAT BAR ═══════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-5 relative z-10 mb-2">
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 flex divide-x divide-gray-100">
        <div class="flex-1 flex items-center gap-3 px-5 py-4">
            <div class="w-9 h-9 rounded-xl bg-[#EAF2EE] flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-[#2B4C3F]" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-[#1E362C] leading-none">{{ $totalHomestay }}</p>
                <p class="text-[10px] text-[#8A9C91] mt-0.5 uppercase tracking-wider">Homestay</p>
            </div>
        </div>
        <div class="flex-1 flex items-center gap-3 px-5 py-4">
            <div class="w-9 h-9 rounded-xl bg-[#FEF9EC] flex items-center justify-center flex-shrink-0">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-[#1E362C] leading-none">{{ $totalSouvenir }}</p>
                <p class="text-[10px] text-[#8A9C91] mt-0.5 uppercase tracking-wider">Souvenir</p>
            </div>
        </div>
        <div class="flex-1 flex items-center gap-3 px-5 py-4">
            <div class="w-9 h-9 rounded-xl {{ $pesananAktif > 0 ? 'bg-blue-50' : 'bg-gray-50' }} flex items-center justify-center flex-shrink-0">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-[#1E362C] leading-none">{{ $pesananAktif }}</p>
                <p class="text-[10px] text-[#8A9C91] mt-0.5 uppercase tracking-wider">Pesanan Aktif</p>
            </div>
        </div>
        <div class="hidden sm:flex flex-1 items-center gap-3 px-5 py-4">
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg style="width:18px;height:18px" fill="none" stroke="#d97706" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-[#1E362C] leading-none">4.8</p>
                <p class="text-[10px] text-[#8A9C91] mt-0.5 uppercase tracking-wider">Rating</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ HOMESTAY ═══════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10">

    {{-- Header --}}
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5] mb-1">Curated Sanctuaries</p>
            <h2 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Homestay Pilihan</h2>
        </div>
        <a href="{{ route('user.homestay') }}" class="text-xs font-bold text-[#2B4C3F] hover:underline flex items-center gap-1 pb-1">
            Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    @if ($homestays->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-gray-100">
            <p class="text-4xl mb-3">🏠</p>
            <p class="text-sm text-[#8A9C91]">Belum ada homestay tersedia.</p>
        </div>
    @else
        {{-- Featured + Side layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

            {{-- Featured card — spans 3 cols --}}
            @php $featured = $homestays->first(); $rating = 4.5 + ($featured->homestay_id % 5) * 0.1; @endphp
            <a href="{{ route('user.homestay.show', $featured->homestay_id) }}"
                class="lg:col-span-3 group relative rounded-[28px] overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 block" style="min-height: 420px;">
                {{-- Image --}}
                @if ($featured->foto)
                    <img src="{{ asset($featured->foto) }}" alt="{{ $featured->nama_homestay }}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=900&q=80"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                {{-- Top badges --}}
                <div class="absolute top-5 left-5 right-5 flex items-center justify-between">
                    <span class="bg-white/95 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-[#1E362C] px-3 py-1.5 rounded-full shadow-sm">
                        ✦ Featured
                    </span>
                    <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-[10px] font-bold text-[#E2A829] shadow-sm">
                        ★ {{ number_format($rating, 1) }}
                    </span>
                </div>

                {{-- Bottom info --}}
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <p class="text-white/60 text-[10px] uppercase tracking-widest mb-1">{{ $featured->kategori->nama_kategori ?? 'Standard' }} · {{ $featured->kapasitas }} tamu</p>
                    <h3 class="font-serif text-2xl sm:text-3xl text-white font-semibold mb-3">{{ $featured->nama_homestay }}</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white/50 text-[9px] uppercase tracking-widest">Mulai dari</span>
                            <p class="text-white font-bold text-lg">Rp {{ number_format($featured->harga_permalam, 0, ',', '.') }}<span class="text-white/50 text-xs font-normal">/malam</span></p>
                        </div>
                        <span class="px-5 py-2.5 bg-white text-[#1E362C] text-xs font-bold rounded-full group-hover:bg-[#EAF2EE] transition-colors shadow-lg">
                            Booking →
                        </span>
                    </div>
                </div>
            </a>

            {{-- Side cards — spans 2 cols, stacked --}}
            <div class="lg:col-span-2 flex flex-row lg:flex-col gap-5">
                @foreach ($homestays->skip(1)->take(2) as $hs)
                    @php $r = 4.5 + ($hs->homestay_id % 5) * 0.1; @endphp
                    <a href="{{ route('user.homestay.show', $hs->homestay_id) }}"
                        class="group flex-1 bg-white rounded-[24px] overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                        <div class="relative h-36 sm:h-44 overflow-hidden bg-[#EAF2EE]/30">
                            @if ($hs->foto)
                                <img src="{{ asset($hs->foto) }}" alt="{{ $hs->nama_homestay }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=500&q=70"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                            @endif
                            <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-[#E2A829] shadow-sm">★ {{ number_format($r, 1) }}</span>
                        </div>
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-serif font-semibold text-[#1E362C] text-sm leading-snug">{{ $hs->nama_homestay }}</h3>
                                <p class="text-[10px] text-[#8A9C91] mt-0.5">{{ $hs->kapasitas }} tamu</p>
                            </div>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#F2F0EA]">
                                <span class="text-sm font-bold text-[#1E362C]">Rp {{ number_format($hs->harga_permalam, 0, ',', '.') }}<span class="text-[9px] text-[#8A9C91] font-normal">/mlm</span></span>
                                <span class="text-[10px] font-semibold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1 rounded-full group-hover:bg-[#2B4C3F] group-hover:text-white transition-colors">Lihat</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>

{{-- ═══════════════ SOUVENIR ═══════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5] mb-1">Local Treasures</p>
            <h2 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Souvenir Terlaris</h2>
        </div>
        <a href="{{ route('user.souvenir') }}" class="text-xs font-bold text-[#2B4C3F] hover:underline flex items-center gap-1 pb-1">
            Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    @if ($souvenirs->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-gray-100">
            <p class="text-4xl mb-3">🛍️</p>
            <p class="text-sm text-[#8A9C91]">Belum ada souvenir tersedia.</p>
        </div>
    @else
        {{-- Layout: 1 featured kiri + 3 kartu kanan dalam 2 baris --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

            {{-- Featured souvenir — kiri, 2 baris tinggi --}}
            @php $feat = $souvenirs->first(); @endphp
            <a href="{{ route('user.souvenir.show', $feat->souvenir_id) }}"
                class="lg:col-span-2 group relative rounded-[28px] overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 block" style="min-height: 380px;">
                {{-- Gambar full-bleed --}}
                @if ($feat->foto)
                    <img src="{{ asset($feat->foto) }}" alt="{{ $feat->nama_souvenir }}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=600&q=80"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

                {{-- Badge terlaris --}}
                <div class="absolute top-5 left-5 right-5 flex items-center justify-between">
                    <span class="bg-[#E9C46A] text-[#1E362C] text-[9px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-sm">
                        🏆 Terlaris
                    </span>
                    @if ($feat->jumlah_terjual > 0)
                        <span class="bg-white/90 backdrop-blur-sm text-[#1E362C] text-[9px] font-bold px-2.5 py-1.5 rounded-full shadow-sm">
                            🔥 {{ $feat->jumlah_terjual }}x terjual
                        </span>
                    @endif
                </div>

                {{-- Info bawah --}}
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <p class="text-white/50 text-[9px] uppercase tracking-widest mb-1">Produk Lokal Harau</p>
                    <h3 class="font-serif text-xl sm:text-2xl text-white font-semibold mb-1 line-clamp-2">{{ $feat->nama_souvenir }}</h3>
                    @if ($feat->detail)
                        <p class="text-white/60 text-xs line-clamp-1 mb-3">{{ $feat->detail }}</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white/50 text-[9px] uppercase tracking-widest">Harga</span>
                            <p class="text-white font-bold text-base">Rp {{ number_format($feat->harga, 0, ',', '.') }}</p>
                        </div>
                        <span class="px-5 py-2.5 bg-white text-[#1E362C] text-xs font-bold rounded-full group-hover:bg-[#EAF2EE] transition-colors shadow-lg">
                            Beli →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 3 kartu kanan dalam 2 baris: 1 lebar di atas, 2 kecil di bawah --}}
            <div class="lg:col-span-3 grid grid-cols-2 grid-rows-2 gap-5">

                {{-- Kartu ke-2: lebar 2 kolom, baris pertama --}}
                @if ($souvenirs->get(1))
                    @php $sv = $souvenirs->get(1); @endphp
                    <a href="{{ route('user.souvenir.show', $sv->souvenir_id) }}"
                        class="col-span-2 group bg-white rounded-[22px] overflow-hidden border border-gray-100 hover:border-[#A7C5B5]/60 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-row">
                        <div class="relative w-2/5 overflow-hidden bg-[#EAF2EE]/30 flex-shrink-0">
                            @if ($sv->foto)
                                <img src="{{ asset($sv->foto) }}" alt="{{ $sv->nama_souvenir }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1612196808214-b8e1d6145a8c?auto=format&fit=crop&w=400&q=70"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                            @endif
                            @if ($sv->jumlah_terjual > 0)
                                <span class="absolute top-3 left-3 bg-[#E9C46A] text-[#1E362C] text-[8px] font-bold px-2 py-1 rounded-full">
                                    🔥 {{ $sv->jumlah_terjual }}x
                                </span>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col justify-between flex-grow">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-widest text-[#A7C5B5] mb-1">Pilihan Populer</p>
                                <h3 class="font-serif font-semibold text-base text-[#1E362C] leading-snug">{{ $sv->nama_souvenir }}</h3>
                                @if ($sv->detail)
                                    <p class="text-xs text-[#8A9C91] mt-1 line-clamp-2 leading-relaxed">{{ $sv->detail }}</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-[#F2F0EA] mt-3">
                                <span class="font-bold text-[#1E362C]">Rp {{ number_format($sv->harga, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-semibold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1.5 rounded-full group-hover:bg-[#2B4C3F] group-hover:text-white transition-colors">
                                    Lihat →
                                </span>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- Kartu ke-3 dan ke-4: masing-masing 1 kolom, baris ke-2 --}}
                @foreach ($souvenirs->slice(2, 2) as $sv)
                    <a href="{{ route('user.souvenir.show', $sv->souvenir_id) }}"
                        class="group bg-white rounded-[22px] overflow-hidden border border-gray-100 hover:border-[#A7C5B5]/60 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                        <div class="relative h-32 sm:h-40 overflow-hidden bg-[#EAF2EE]/30">
                            @if ($sv->foto)
                                <img src="{{ asset($sv->foto) }}" alt="{{ $sv->nama_souvenir }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=300&q=70"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
                            @endif
                            @if ($sv->jumlah_terjual > 0)
                                <span class="absolute top-2.5 left-2.5 bg-[#E9C46A] text-[#1E362C] text-[8px] font-bold px-2 py-1 rounded-full shadow-sm">
                                    🔥 {{ $sv->jumlah_terjual }}x
                                </span>
                            @endif
                        </div>
                        <div class="p-3.5 flex-grow flex flex-col justify-between gap-2">
                            <h3 class="font-semibold text-xs text-[#1E362C] leading-snug line-clamp-2">{{ $sv->nama_souvenir }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-[#1E362C]">Rp {{ number_format($sv->harga, 0, ',', '.') }}</span>
                                <span class="text-[9px] font-semibold text-[#2B4C3F] bg-[#EAF2EE] px-2.5 py-1 rounded-full group-hover:bg-[#2B4C3F] group-hover:text-white transition-colors">
                                    Beli
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    @endif
</section>

{{-- ═══════════════ PESANAN TERAKHIR ═══════════════ --}}
@if ($pesananTerakhir->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-16">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5] mb-1">Aktivitas Kamu</p>
            <h2 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Pesanan Terakhir</h2>
        </div>
        <a href="{{ route('user.pesanan.index') }}" class="text-xs font-bold text-[#2B4C3F] hover:underline flex items-center gap-1 pb-1">
            Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ($pesananTerakhir as $pesanan)
            @php
                $statusColor = match($pesanan->status_pemesanan) {
                    'menunggu_pembayaran' => ['pill' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-400'],
                    'menunggu_verifikasi' => ['pill' => 'bg-blue-50 text-blue-700 border-blue-200', 'dot' => 'bg-blue-400'],
                    'diproses','dikonfirmasi','sedang_menginap' => ['pill' => 'bg-[#EAF2EE] text-[#2B4C3F] border-[#A7C5B5]', 'dot' => 'bg-[#4ade80]'],
                    'selesai'             => ['pill' => 'bg-gray-50 text-gray-500 border-gray-200', 'dot' => 'bg-gray-300'],
                    'dibatalkan'          => ['pill' => 'bg-red-50 text-red-600 border-red-200', 'dot' => 'bg-red-400'],
                    'kedaluwarsa'         => ['pill' => 'bg-stone-50 text-stone-600 border-stone-200', 'dot' => 'bg-stone-300'],
                    default               => ['pill' => 'bg-gray-50 text-gray-500 border-gray-200', 'dot' => 'bg-gray-300'],
                };
                $statusLabel = match($pesanan->status_pemesanan) {
                    'menunggu_pembayaran' => 'Menunggu Bayar',
                    'menunggu_verifikasi' => 'Verifikasi',
                    'diproses'            => 'Diproses',
                    'dikonfirmasi'        => 'Dikonfirmasi',
                    'sedang_menginap'     => 'Sedang Menginap',
                    'selesai'             => 'Selesai',
                    'dibatalkan'          => 'Dibatalkan',
                    'kedaluwarsa'         => 'Kedaluwarsa',
                    default               => ucwords(str_replace('_', ' ', $pesanan->status_pemesanan)),
                };
            @endphp
            <a href="{{ route('user.pesanan.show', $pesanan->pemesanan_id) }}"
                class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-[#A7C5B5] hover:shadow-md transition-all duration-200 flex flex-col gap-4">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl bg-[#EAF2EE] flex items-center justify-center flex-shrink-0">
                        @if ($pesanan->jenis_pemesanan === 'homestay')
                            <svg class="w-5 h-5 text-[#2B4C3F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-[#2B4C3F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        @endif
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border {{ $statusColor['pill'] }} flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                        {{ $statusLabel }}
                    </span>
                </div>
                <div>
                    <p class="font-mono text-xs font-semibold text-[#1E362C]">{{ $pesanan->kode_pemesanan }}</p>
                    <p class="text-[10px] text-[#8A9C91] capitalize mt-0.5">{{ $pesanan->jenis_pemesanan }} · {{ $pesanan->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-[#F2F0EA]">
                    <span class="font-bold text-sm text-[#1E362C]">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    <svg class="w-4 h-4 text-[#8A9C91] group-hover:text-[#2B4C3F] group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

@endsection
