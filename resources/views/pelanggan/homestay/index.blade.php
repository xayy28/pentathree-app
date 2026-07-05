@extends('layouts.user')

@section('title', 'Menu Homestay')

@section('content')
    <div class="space-y-8">
        <!-- USER INTERFACE (Katalog Homestay Sesuai Mockup) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-transparent">

            <!-- Section Title & Search Needs -->
            <div class="text-center space-y-8">
                <div class="space-y-2">
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#8A9C91] block">Natasha Retreat</span>
                    <h2 class="font-serif text-3xl sm:text-4xl text-[#1E362C] font-semibold tracking-wide uppercase">
                        Daftar Homestay
                    </h2>
                </div>

                <form action="{{ route('user.homestay') }}" method="GET"
                    class="max-w-4xl mx-auto bg-white rounded-3xl sm:rounded-full border border-gray-200/80 shadow-md p-2 sm:p-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <div class="flex-1 px-5 py-2 border-b sm:border-b-0 sm:border-r border-gray-100 text-left space-y-0.5">
                        <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8A9C91]">KATEGORI</span>
                        <select name="kategori"
                            class="w-full bg-transparent text-sm font-medium text-[#1E362C] border-0 p-0 focus:ring-0">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->kategori_id }}" @selected((string) $kategori === (string) $category->kategori_id)>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 px-5 py-2 border-b sm:border-b-0 sm:border-r border-gray-100 text-left space-y-0.5">
                        <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8A9C91]">STATUS</span>
                        <select name="status"
                            class="w-full bg-transparent text-sm font-medium text-[#1E362C] border-0 p-0 focus:ring-0">
                            <option value="">Semua status</option>
                            @foreach ($statuses as $statusOption)
                                <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 px-5 py-2 text-left space-y-0.5">
                        <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8A9C91]">TAMU</span>
                        <select name="tamu"
                            class="w-full bg-transparent text-sm font-medium text-[#1E362C] border-0 p-0 focus:ring-0">
                            <option value="">Semua kapasitas</option>
                            @foreach ([1, 2, 3, 4, 5] as $guestCount)
                                <option value="{{ $guestCount }}" @selected((string) $tamu === (string) $guestCount)>
                                    {{ $guestCount === 5 ? '5+ Orang' : $guestCount . ' Orang' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-[#1E362C] hover:bg-[#152720] text-white font-semibold rounded-2xl sm:rounded-full px-6 py-3 flex items-center justify-center gap-2 shadow-sm transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                            <span class="text-xs uppercase tracking-widest">Filter</span>
                        </button>
                        <a href="{{ route('user.homestay') }}"
                            class="bg-[#FAF9F6] hover:bg-[#F2F0EA] text-[#5C6E65] font-semibold rounded-2xl sm:rounded-full px-5 py-3 flex items-center justify-center text-xs uppercase tracking-widest border border-gray-200 transition-all">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Main Catalog Area (Sidebar + Rooms Grid) -->
            <div class="flex flex-col md:flex-row gap-10 items-start">

                <!-- Left Sidebar: Filter Stays -->
                <div class="w-full md:w-64 flex-shrink-0 md:space-y-6">
                    <h3
                        class="hidden md:block font-serif text-2xl text-[#1E362C] font-semibold tracking-wide border-b border-gray-200 pb-3">
                        Filter Stays
                    </h3>
                    <div class="flex flex-row md:flex-col gap-3 overflow-x-auto pb-3 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-none"
                        id="category-filters">
                        <a href="{{ route('user.homestay', array_filter(['status' => $status, 'tamu' => $tamu], fn ($value) => filled($value))) }}"
                            class="flex items-center justify-center md:justify-start gap-2 md:gap-4 w-auto md:w-full px-4 md:px-5 py-2.5 md:py-4 rounded-xl md:rounded-2xl border transition-all text-center md:text-left whitespace-nowrap {{ blank($kategori) ? 'border-[#1E362C] font-semibold shadow-sm bg-[#1E362C] text-white hover:bg-[#152720] hover:text-white' : 'border-gray-200 font-medium bg-white text-[#5C6E65] hover:text-[#1E362C] hover:bg-[#EAF2EE] hover:border-[#B8DEC8] hover:shadow-sm' }}">
                            <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span>All Rooms</span>
                        </a>

                        @foreach ($categories as $category)
                            @php
                                // Determine an icon based on category name
                                $iconPath =
                                    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'; // default
                                if (strtolower($category->nama_kategori) === 'suites') {
                                    $iconPath =
                                        'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z';
                                } elseif (strtolower($category->nama_kategori) === 'deluxe') {
                                    $iconPath = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                                }
                            @endphp
                            <a href="{{ route('user.homestay', array_filter(['kategori' => $category->kategori_id, 'status' => $status, 'tamu' => $tamu], fn ($value) => filled($value))) }}"
                                class="flex items-center justify-center md:justify-start gap-2 md:gap-4 w-auto md:w-full px-4 md:px-5 py-2.5 md:py-4 rounded-xl md:rounded-2xl border transition-all text-center md:text-left whitespace-nowrap {{ (string) $kategori === (string) $category->kategori_id ? 'border-[#1E362C] font-semibold shadow-sm bg-[#1E362C] text-white hover:bg-[#152720] hover:text-white' : 'border-gray-200 font-medium bg-white text-[#5C6E65] hover:text-[#1E362C] hover:bg-[#EAF2EE] hover:border-[#B8DEC8] hover:shadow-sm' }}">
                                <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $iconPath }}"></path>
                                </svg>
                                <span>{{ $category->nama_kategori }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Right Content: Room Grid -->
                <div class="flex-grow w-full space-y-6">
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]"
                        id="room-count-label">
                        Menampilkan {{ $homestays->count() }} Kamar yang Tersedia
                    </span>

                    @if ($homestays->isEmpty())
                        <div
                            class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center flex flex-col items-center justify-center shadow-sm">
                            <span class="text-5xl mb-4">🏠</span>
                            <h3 class="text-lg font-serif font-semibold text-[#1E362C] mb-1">Homestay Belum Tersedia</h3>
                            <p class="text-xs text-[#8A9C91] max-w-sm">
                                Kami sedang menyiapkan beberapa pilihan homestay terbaik untuk Anda. Silakan kembali
                                beberapa saat lagi!
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8" id="homestay-grid">
                            @foreach ($homestays as $homestay)
                                @php
                                    // Dynamic Star Rating calculation based on homestay ID for mockup aesthetic
                                    $rating = 4.5 + ($homestay->homestay_id % 5) * 0.1;
                                @endphp
                                <div class="bg-white rounded-[32px] overflow-hidden border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between p-4 homestay-card"
                                    data-category="{{ $homestay->kategori_id }}" data-capacity="{{ $homestay->kapasitas }}">
                                    <div>
                                        <!-- Image Container -->
                                        <div class="h-60 overflow-hidden relative bg-[#EAF2EE]/50 rounded-2xl">
                                            @if ($homestay->foto)
                                                <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}"
                                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80"
                                                    alt="{{ $homestay->nama_homestay }}"
                                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
                                            @endif

                                            <!-- Status Badge -->
                                            @if ($homestay->status === 'Tersedia')
                                                <span
                                                    class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm border border-gray-200 text-[9px] font-bold uppercase tracking-wider text-[#1E362C] px-2.5 py-1 rounded-full shadow-sm z-10">
                                                    Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-white px-2.5 py-1 rounded-full shadow-sm z-10">
                                                    {{ $homestay->status }}
                                                </span>
                                            @endif

                                            <!-- Rating Badge -->
                                            <span
                                                class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-bold text-[#E2A829] shadow-sm flex items-center gap-1 z-10">
                                                ★ {{ number_format($rating, 1) }}
                                            </span>
                                        </div>

                                        <!-- Room Info -->
                                        <div class="p-4 pt-5 pb-3 space-y-3">
                                            <h4
                                                class="font-serif font-semibold text-xl text-[#1E362C] pb-2 border-b border-gray-100">
                                                {{ $homestay->nama_homestay }}
                                            </h4>
                                            <p class="text-xs text-[#8A9C91] leading-relaxed">
                                                Kapasitas: {{ $homestay->kapasitas }} Orang &bull;
                                                {{ $homestay->kategori->nama_kategori ?? 'Standard' }}
                                            </p>
                                            @if ($homestay->detail)
                                                <p class="text-xs text-[#5C6E65] line-clamp-2 leading-relaxed"
                                                    title="{{ $homestay->detail }}">
                                                    {{ $homestay->detail }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price & Action -->
                                    <div class="p-4 pt-0">
                                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                            <div>
                                                <span class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Mulai
                                                    dari</span>
                                                <span class="text-base font-bold text-[#1E362C]">Rp
                                                    {{ number_format($homestay->harga_permalam, 0, ',', '.') }}<span
                                                        class="text-[10px] text-[#8A9C91] font-normal uppercase tracking-normal">/malam</span></span>
                                            </div>
                                            @if ($homestay->status === 'Tersedia')
                                                <a href="{{ route('user.homestay.booking.create', $homestay->homestay_id) }}"
                                                    class="px-6 py-2.5 bg-[#1E362C] hover:bg-[#152720] text-white text-xs font-semibold rounded-xl transition-all shadow-sm cursor-pointer">
                                                    BOOKING
                                                </a>
                                            @else
                                                <button disabled
                                                    class="px-6 py-2.5 bg-[#FAF9F6] border border-gray-200 text-[#8A9C91] text-xs font-semibold rounded-xl cursor-not-allowed">
                                                    Penuh
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
