@extends('layouts.user')

@section('title', $homestay->nama_homestay)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#8A9C91]">
            <a href="{{ route('user.homestay') }}" class="hover:text-[#2B4C3F] transition-colors flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Katalog Homestay
            </a>
            <span class="text-[#D1D5DB]">/</span>
            <span class="text-[#2B4C3F] font-medium truncate max-w-[220px]">{{ $homestay->nama_homestay }}</span>
        </nav>

        {{-- Main Content --}}
        <div class="flex flex-col lg:flex-row gap-10 items-start">

            {{-- Left: Photo --}}
            <div class="w-full lg:w-[55%] space-y-4">
                <div class="relative rounded-[32px] overflow-hidden bg-[#EAF2EE]/50 aspect-[4/3]">
                    @if ($homestay->foto)
                        <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}"
                            class="w-full h-full object-cover transition-opacity duration-300">
                    @else
                        <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80"
                            alt="{{ $homestay->nama_homestay }}"
                            class="w-full h-full object-cover transition-opacity duration-300">
                    @endif

                    {{-- Status Badge --}}
                    <span
                        class="absolute top-5 left-5 {{ $homestay->status === 'Tersedia' ? 'bg-white/95 text-[#2B4C3F] border border-[#A7C5B5]/30' : 'bg-[#E65F5F]/90 text-white' }} backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-sm">
                        {{ $homestay->status }}
                    </span>
                    {{-- Rating Badge --}}
                    <div class="absolute top-5 right-5">
                        @include('pelanggan.partials.rating-summary', [
                            'rating' => $homestay->ulasans_avg_rating,
                            'count' => $homestay->ulasans_count,
                        ])
                    </div>
                </div>
            </div>

            {{-- Right: Info & Action --}}
            <div class="w-full lg:w-[45%] space-y-6">

                {{-- Header --}}
                <div class="space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">
                        Natasha Retreat — {{ $homestay->kategori->nama_kategori ?? 'Homestay' }}
                    </span>
                    <h1 class="font-serif text-3xl sm:text-4xl font-semibold text-[#2B4C3F] leading-tight">
                        {{ $homestay->nama_homestay }}
                    </h1>
                    @include('pelanggan.partials.rating-summary', [
                        'rating' => $homestay->ulasans_avg_rating,
                        'count' => $homestay->ulasans_count,
                    ])
                </div>

                {{-- Price --}}
                <div class="flex items-end gap-3 py-4 border-y border-[#E6E4DD]">
                    <div>
                        <span class="text-[9px] text-[#8A9C91] uppercase tracking-widest block mb-0.5">Harga per Malam</span>
                        <span class="font-serif text-3xl font-bold text-[#2B4C3F]">
                            Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-[#8A9C91] ml-1">/ malam</span>
                    </div>
                </div>

                {{-- Info Stats --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-[#F8F7F4] rounded-2xl p-4 text-center border border-[#E6E4DD]">
                        <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Kapasitas</span>
                        <span class="text-base font-bold text-[#2B4C3F]">{{ $homestay->kapasitas }}</span>
                        <span class="text-[9px] text-[#8A9C91]">tamu</span>
                    </div>
                    <div class="bg-[#EAF2EE] rounded-2xl p-4 text-center border border-[#A7C5B5]/40">
                        <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Kategori</span>
                        <span class="text-xs font-bold text-[#2B4C3F] leading-tight block mt-0.5">
                            {{ $homestay->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>
                    <div class="bg-[#F8F7F4] rounded-2xl p-4 text-center border border-[#E6E4DD]">
                        <span class="text-[9px] uppercase tracking-widest text-[#8A9C91] block">Status</span>
                        <span
                            class="text-xs font-bold {{ $homestay->status === 'Tersedia' ? 'text-[#2B4C3F]' : 'text-[#E65F5F]' }}">
                            {{ $homestay->status }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                @if ($homestay->detail)
                    <div class="space-y-2">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Deskripsi</h3>
                        <p class="text-sm text-[#5C6E65] leading-relaxed">
                            {{ $homestay->detail }}
                        </p>
                    </div>
                @endif

                {{-- Fasilitas dari database --}}
                @if ($homestay->fasilitas->isNotEmpty())
                    <div class="space-y-2">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Fasilitas Umum</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($homestay->fasilitas as $f)
                                @php
                                    $ikonMap = [
                                        'wifi'     => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0',
                                        'ac'       => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                        'shower'  => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z',
                                        'parking' => 'M19 9l-7 7-7-7',
                                        'kitchen' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                                        'pool'    => 'M10 21h4a2 2 0 002-2v-2a2 2 0 00-2-2h-4a2 2 0 00-2 2v2a2 2 0 002 2zm-4-8h12M6 9V7a6 6 0 1112 0v2',
                                        'tv'      => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                        'breakfast' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 0c1.657 0 3-.895 3-2s-1.343-2-3-2-3 .895-3 2 1.343 2 3 2zm-6 8h12M4 22h16',
                                    ];
                                @endphp
                                <div class="flex items-center gap-2.5 text-xs text-[#5C6E65] bg-[#FAF9F6] rounded-xl p-3 border border-[#E6E4DD]">
                                    <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ikonMap[$f->ikon] ?? 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0' }}" />
                                    </svg>
                                    {{ $f->nama_fasilitas }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Info baris --}}
                <div class="space-y-2.5 py-4 border-t border-[#E6E4DD]">
                    <div class="flex items-center gap-3 text-xs text-[#5C6E65]">
                        <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Berlokasi di Lembah Harau, Payakumbuh, Sumatera Barat
                    </div>
                    <div class="flex items-center gap-3 text-xs text-[#5C6E65]">
                        <svg class="w-4 h-4 text-[#A7C5B5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Check-in 14.00 — Check-out 12.00
                    </div>
                </div>

                {{-- CTA Booking --}}
                @if ($homestay->status === 'Tersedia')
                    <div class="space-y-3 pt-2">
                        <x-ui-button href="{{ route('user.homestay.booking.create', $homestay->homestay_id) }}" variant="primary" size="lg" block>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Booking Sekarang
                        </x-ui-button>
                        <x-ui-button href="{{ route('user.homestay') }}" variant="secondary" block>
                            Lihat Homestay Lainnya
                        </x-ui-button>
                    </div>
                @else
                    <div class="space-y-3 pt-2">
                        <x-ui-button variant="disabled" size="lg" block disabled>
                            Tidak Tersedia
                        </x-ui-button>
                        <x-ui-button href="{{ route('user.homestay') }}" variant="secondary" block>
                            Lihat Homestay Lainnya
                        </x-ui-button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Ulasan Pelanggan --}}
        <div class="space-y-5 pt-4 border-t border-[#E6E4DD]">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">Rating</span>
                <h2 class="font-serif text-2xl font-semibold text-[#2B4C3F]">Ulasan Pelanggan</h2>
            </div>

            @forelse ($homestay->ulasans->sortByDesc('created_at')->take(6) as $ulasan)
                <div class="bg-white rounded-2xl border border-[#E6E4DD] p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                        <div>
                            <div class="font-semibold text-[#2C3E35]">{{ $ulasan->user->nama }}</div>
                            <div class="mt-1 text-xs text-[#B7791F]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $ulasan->rating ? 'text-[#B7791F]' : 'text-[#D8D5CC]' }}">&#9733;</span>
                                @endfor
                                <span class="ml-1 text-[#8A9C91]">{{ $ulasan->rating }} dari 5</span>
                            </div>
                        </div>
                        <div class="text-xs text-[#8A9C91]">{{ $ulasan->created_at->format('d M Y') }}</div>
                    </div>
                    @if ($ulasan->komentar)
                        <p class="mt-3 text-sm leading-relaxed text-[#5C6E65]">{{ $ulasan->komentar }}</p>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 text-sm text-[#8A9C91]">
                    Belum ada ulasan untuk homestay ini.
                </div>
            @endforelse
        </div>

        {{-- Rekomendasi Homestay Lainnya --}}
        @if ($rekomendasi->isNotEmpty())
            <div class="space-y-6 pt-4 border-t border-[#E6E4DD]">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">
                            Pilihan Lainnya
                        </span>
                        <h2 class="font-serif text-2xl font-semibold text-[#2B4C3F]">Homestay Lainnya</h2>
                    </div>
                    <a href="{{ route('user.homestay') }}"
                        class="text-xs font-semibold text-[#2B4C3F] hover:underline flex items-center gap-1">
                        Lihat Semua
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ($rekomendasi as $item)
                        <a href="{{ route('user.homestay.show', $item->homestay_id) }}"
                            class="bg-white rounded-[28px] overflow-hidden border border-[#E6E4DD]/60 shadow-sm hover:shadow-md hover:border-[#A7C5B5]/40 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col">
                            <div class="h-44 overflow-hidden relative bg-[#EAF2EE]/30">
                                @if ($item->foto)
                                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_homestay }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=400&q=80"
                                        alt="{{ $item->nama_homestay }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                                <div class="absolute top-3 right-3">
                                    @include('pelanggan.partials.rating-summary', [
                                        'rating' => $item->ulasans_avg_rating,
                                        'count' => $item->ulasans_count,
                                    ])
                                </div>
                            </div>
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <h4 class="font-serif font-semibold text-[#2B4C3F] text-base mb-1">
                                        {{ $item->nama_homestay }}
                                    </h4>
                                    <p class="text-xs text-[#8A9C91]">
                                        {{ $item->kapasitas }} tamu · {{ $item->kategori->nama_kategori ?? 'Standard' }}
                                    </p>
                                    @if ($item->detail)
                                        <p class="text-xs text-[#8A9C91] line-clamp-2 leading-relaxed mt-1">{{ $item->detail }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-[#F2F0EA]">
                                    <div>
                                        <span class="text-[9px] text-[#8A9C91] block">Mulai dari</span>
                                        <span class="text-sm font-bold text-[#2B4C3F]">
                                            Rp {{ number_format($item->harga_permalam, 0, ',', '.') }}<span class="text-[10px] text-[#8A9C91] font-normal">/malam</span>
                                        </span>
                                    </div>
                                    <span class="text-[10px] font-semibold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1 rounded-full">
                                        Lihat
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
