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
                    class="max-w-3xl mx-auto bg-white rounded-3xl sm:rounded-full border border-gray-200/80 shadow-md p-2 sm:p-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
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
                        <x-ui-button type="submit" variant="primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Filter</span>
                        </x-ui-button>
                        <x-ui-button href="{{ route('user.homestay') }}" variant="muted">
                            Reset
                        </x-ui-button>
                    </div>
                </form>
            </div>

            <!-- Main Catalog Area (Rooms Grid) -->
            <div class="space-y-6">
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
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="homestay-grid">
                            @foreach ($homestays as $homestay)
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
                                            <div class="absolute top-4 right-4 z-10">
                                                @include('pelanggan.partials.rating-summary', [
                                                    'rating' => $homestay->ulasans_avg_rating,
                                                    'count' => $homestay->ulasans_count,
                                                ])
                                            </div>
                                        </div>

                                        <!-- Room Info -->
                                        <div class="p-4 pt-5 pb-3 space-y-3">
                                            <h4
                                                class="font-serif font-semibold text-xl text-[#1E362C] pb-2 border-b border-gray-100">
                                                <a href="{{ route('user.homestay.show', $homestay->homestay_id) }}" class="hover:text-[#2B4C3F] transition-colors">
                                                    {{ $homestay->nama_homestay }}
                                                </a>
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
                                            <div class="flex items-center gap-2">
                                                <x-ui-button href="{{ route('user.homestay.show', $homestay->homestay_id) }}" variant="secondary" size="sm">
                                                    Detail
                                                </x-ui-button>
                                                @if ($homestay->status === 'Tersedia')
                                                    <x-ui-button href="{{ route('user.homestay.booking.create', $homestay->homestay_id) }}" variant="primary" size="sm">
                                                        Booking
                                                    </x-ui-button>
                                                @else
                                                    <x-ui-button variant="disabled" size="sm" disabled>
                                                        Penuh
                                                    </x-ui-button>
                                                @endif
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
    </div>
@endsection
