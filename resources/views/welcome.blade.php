<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natasha Homestay & Souvenir — Lembah Harau</title>
    <meta name="description" content="Homestay autentik dan souvenir khas Lembah Harau. Nikmati ketenangan alam bersama Natasha Retreat.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
        .font-sans  { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans bg-[#FAF9F6] text-[#2C3E35] antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-xl border-b border-[#E6E4DD]/60 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Logo" class="h-9 w-9 rounded-full object-cover border-2 border-[#2B4C3F]/20">
            <span class="font-serif font-semibold text-[#2B4C3F] text-base leading-tight">Natasha Homestay</span>
        </a>
        <div class="hidden sm:flex items-center gap-6 text-sm font-medium text-[#5C6E65]">
            <a href="#homestay" class="hover:text-[#2B4C3F] transition-colors">Homestay</a>
            <a href="#souvenir" class="hover:text-[#2B4C3F] transition-colors">Souvenir</a>
            <a href="#tentang"  class="hover:text-[#2B4C3F] transition-colors">Tentang</a>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2B4C3F] border border-[#2B4C3F]/30 hover:border-[#2B4C3F] hover:bg-[#EAF2EE] px-4 py-2 rounded-full transition-all duration-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-1.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold px-5 py-2 rounded-full transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar
            </a>
        </div>
    </div>
</nav>

{{-- ═══════ HERO ═══════ --}}
<section class="relative min-h-screen flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero-banner1.png') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#0d1f18]/80 via-[#1E362C]/60 to-[#2B4C3F]/30"></div>
        <div class="absolute bottom-0 inset-x-0 h-48 bg-gradient-to-t from-[#FAF9F6] to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-32 sm:pb-48">
        <div class="max-w-2xl space-y-6">
            <div class="flex items-center gap-2">
                <div class="h-px w-8 bg-[#A7C5B5]"></div>
                <span class="text-[10px] font-bold tracking-[0.35em] uppercase text-[#A7C5B5]">Natasha Retreat · Lembah Harau</span>
            </div>
            <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl font-semibold text-white leading-[1.05] tracking-tight">
                Temukan<br>
                <span class="italic text-[#A7C5B5]">Ketenangan</span><br>
                di Alam Harau
            </h1>
            <p class="text-white/70 text-base sm:text-lg leading-relaxed max-w-md">
                Homestay autentik dan souvenir khas lokal — satu tempat untuk semua pengalaman terbaik kamu di Lembah Harau.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-[#1E362C] text-sm font-bold uppercase tracking-widest rounded-full hover:bg-[#EAF2EE] transition-all shadow-xl">
                    Mulai Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="#homestay" class="inline-flex items-center gap-2 px-7 py-3.5 bg-transparent border border-white/40 text-white text-sm font-bold uppercase tracking-widest rounded-full hover:bg-white/10 backdrop-blur-sm transition-all">
                    Lihat Homestay
                </a>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-white/50 animate-bounce">
        <span class="text-[10px] uppercase tracking-widest">Scroll</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ═══════ STAT BAR ═══════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 mb-16">
    <div class="bg-white rounded-2xl shadow-lg border border-[#E6E4DD] grid grid-cols-2 sm:grid-cols-4 divide-x divide-[#F2F0EA]">
        <div class="flex flex-col items-center py-6 px-4 gap-1">
            <span class="text-2xl font-bold text-[#2B4C3F]">{{ $statTotalHomestay }}</span>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]">Unit Homestay</span>
        </div>
        <div class="flex flex-col items-center py-6 px-4 gap-1">
            <span class="text-2xl font-bold text-[#2B4C3F]">{{ $statTotalSouvenir }}</span>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]">Souvenir Khas</span>
        </div>
        <div class="flex flex-col items-center py-6 px-4 gap-1">
            <span class="text-2xl font-bold text-[#2B4C3F]">
                @if ($statAvgRating)
                    ★ {{ number_format($statAvgRating, 1) }}
                @else
                    —
                @endif
            </span>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]">Rating Tamu</span>
        </div>
        <div class="flex flex-col items-center py-6 px-4 gap-1">
            <span class="text-2xl font-bold text-[#2B4C3F]">{{ $statTotalUser }}</span>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]">Pelanggan</span>
        </div>
    </div>
</div>

{{-- ═══════ HOMESTAY ═══════ --}}
<section id="homestay" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5] mb-1">Curated Sanctuaries</p>
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold">Homestay Pilihan</h2>
        </div>
        <a href="{{ route('login') }}" class="text-xs font-bold text-[#2B4C3F] hover:underline flex items-center gap-1">
            Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    @if ($homestays->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-[#E6E4DD]">
            <p class="text-4xl mb-3">🏠</p>
            <p class="text-sm text-[#8A9C91]">Segera hadir homestay pilihan kami.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($homestays as $hs)
                @php $rating = 4.5 + ($hs->homestay_id % 5) * 0.1; @endphp
                <div class="group bg-white rounded-[24px] overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative h-52 overflow-hidden bg-[#EAF2EE]/30">
                        @if ($hs->foto)
                            <img src="{{ asset($hs->foto) }}" alt="{{ $hs->nama_homestay }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=600&q=70" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                        @endif
                        <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-[10px] font-bold text-[#E2A829] shadow-sm">★ {{ number_format($rating, 1) }}</span>
                        <span class="absolute top-3 left-3 bg-white/90 text-[#2B4C3F] text-[9px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full">{{ $hs->kategori->nama_kategori ?? 'Standard' }}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-serif font-semibold text-[#1E362C] text-lg leading-snug">{{ $hs->nama_homestay }}</h3>
                        <p class="text-xs text-[#8A9C91] mt-1 mb-4">{{ $hs->kapasitas }} tamu · Lembah Harau</p>
                        <div class="mt-auto flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                            <div>
                                <span class="text-[9px] text-[#8A9C91] uppercase tracking-wider">Mulai dari</span>
                                <p class="font-bold text-[#1E362C] text-base">Rp {{ number_format($hs->harga_permalam, 0, ',', '.') }}<span class="text-xs text-[#8A9C91] font-normal">/malam</span></p>
                            </div>
                            <a href="{{ route('login') }}" class="bg-[#EAF2EE] hover:bg-[#2B4C3F] hover:text-white text-[#2B4C3F] text-xs font-bold px-4 py-2 rounded-full transition-all">Booking</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- ═══════ SOUVENIR ═══════ --}}
<section id="souvenir" class="bg-[#F2F0EA] py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5] mb-1">Local Treasures</p>
                <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold">Souvenir Terlaris</h2>
            </div>
            <a href="{{ route('login') }}" class="text-xs font-bold text-[#2B4C3F] hover:underline flex items-center gap-1">
                Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if ($souvenirs->isEmpty())
            <div class="bg-white rounded-3xl p-16 text-center border border-[#E6E4DD]">
                <p class="text-4xl mb-3">🛍️</p>
                <p class="text-sm text-[#8A9C91]">Souvenir pilihan segera hadir.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($souvenirs as $sv)
                    <div class="group bg-white rounded-[22px] overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                        <div class="relative h-40 sm:h-48 overflow-hidden bg-[#EAF2EE]/30">
                            @if ($sv->foto)
                                <img src="{{ asset($sv->foto) }}" alt="{{ $sv->nama_souvenir }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=400&q=70" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                            @endif
                            @if ($sv->jumlah_terjual > 0)
                                <span class="absolute top-2.5 left-2.5 bg-[#E9C46A] text-[#1E362C] text-[8px] font-bold px-2 py-1 rounded-full shadow-sm">🔥 {{ $sv->jumlah_terjual }}x</span>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-grow gap-2">
                            <h3 class="font-semibold text-sm text-[#1E362C] leading-snug line-clamp-2">{{ $sv->nama_souvenir }}</h3>
                            <div class="mt-auto flex items-center justify-between pt-2 border-t border-[#F2F0EA]">
                                <span class="font-bold text-sm text-[#1E362C]">Rp {{ number_format($sv->harga, 0, ',', '.') }}</span>
                                <a href="{{ route('login') }}" class="text-[10px] font-bold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1.5 rounded-full hover:bg-[#2B4C3F] hover:text-white transition-colors">Beli</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ═══════ TENTANG ═══════ --}}
<section id="tentang" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
        <div class="space-y-6">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A7C5B5]">Tentang Kami</p>
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold leading-snug">
                Pengalaman Menginap<br>yang Tak Terlupakan
            </h2>
            <p class="text-[#5C6E65] leading-relaxed text-sm sm:text-base">
                Natasha Homestay hadir di tengah keindahan Lembah Harau, Sumatera Barat. Kami menawarkan tempat menginap nyaman dengan nuansa lokal yang autentik, serta koleksi souvenir khas buatan pengrajin setempat.
            </p>
            <ul class="space-y-3 text-sm text-[#5C6E65]">
                <li class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Lokasi strategis di kawasan Lembah Harau
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Souvenir 100% produk lokal pengrajin Harau
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Pembayaran mudah dan terverifikasi
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Pemesanan online 24 jam
                </li>
            </ul>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-bold px-7 py-3.5 rounded-full transition-all shadow-md">
                Daftar Gratis
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="relative rounded-[32px] overflow-hidden shadow-2xl aspect-[4/3] bg-[#EAF2EE]">
            <img src="{{ asset('images/hero-banner1.png') }}" alt="Lembah Harau" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1E362C]/40 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-sm rounded-2xl p-4">
                <p class="font-serif text-sm font-semibold text-[#1E362C]">Natasha Retreat</p>
                <p class="text-xs text-[#5C6E65] mt-0.5">Lembah Harau, Sumatera Barat</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════ CTA BAND ═══════ --}}
<section class="bg-[#2B4C3F] py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <p class="text-[10px] font-bold uppercase tracking-[0.35em] text-[#A7C5B5]">Siap Berlibur?</p>
        <h2 class="font-serif text-3xl sm:text-4xl text-white font-semibold leading-snug">
            Booking Homestay atau<br>Beli Souvenir Sekarang
        </h2>
        <p class="text-white/60 text-sm sm:text-base max-w-md mx-auto leading-relaxed">
            Buat akun gratis dan mulai pesan — proses mudah, pembayaran aman, barang langsung dikirim.
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-2">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-[#1E362C] text-sm font-bold px-8 py-3.5 rounded-full hover:bg-[#EAF2EE] transition-all shadow-lg">
                Buat Akun
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 border border-white/30 text-white text-sm font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition-all">
                Sudah Punya Akun? Masuk
            </a>
        </div>
    </div>
</section>

{{-- ═══════ FOOTER ═══════ --}}
<footer class="bg-[#1E362C] text-[#A7C5B5] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Logo" class="h-9 w-9 rounded-full object-cover border-2 border-white/20">
                <div>
                    <p class="font-serif font-semibold text-white text-sm">Natasha Homestay</p>
                    <p class="text-[10px] text-[#A7C5B5] mt-0.5">Lembah Harau, Sumatera Barat</p>
                </div>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <a href="#homestay" class="hover:text-white transition-colors">Homestay</a>
                <a href="#souvenir" class="hover:text-white transition-colors">Souvenir</a>
                <a href="#tentang"  class="hover:text-white transition-colors">Tentang</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a>
            </div>
        </div>
        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#8A9C91]">
            <p>&copy; {{ date('Y') }} PentaThree. Hak cipta dilindungi.</p>
            <p>Dibuat dengan ❤ untuk wisata Lembah Harau</p>
        </div>
    </div>
</footer>

</body>
</html>
