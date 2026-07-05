@extends('layouts.user')

@section('title', 'Booking Homestay')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
                <a href="{{ route('user.homestay') }}" class="text-xs font-semibold text-[#5C6E65] hover:text-[#2B4C3F]">
                    &larr; Kembali ke Homestay
                </a>
                <h2 class="font-serif text-3xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-4">
                    Booking Homestay
                </h2>
                <p class="text-sm text-[#5C6E65] mt-2">
                    Pilih tanggal menginap untuk {{ $homestay->nama_homestay }}.
                </p>

                <form action="{{ route('user.homestay.booking.store', $homestay->homestay_id) }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="check_in" class="block text-sm font-semibold text-[#2C3E35] mb-2">Check-in</label>
                            <input type="date" name="check_in" id="check_in" min="{{ now()->toDateString() }}" value="{{ old('check_in') }}"
                                class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                            @error('check_in')
                                <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="check_out" class="block text-sm font-semibold text-[#2C3E35] mb-2">Check-out</label>
                            <input type="date" name="check_out" id="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out') }}"
                                class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                            @error('check_out')
                                <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="jumlah_tamu" class="block text-sm font-semibold text-[#2C3E35] mb-2">Jumlah Tamu</label>
                        <input type="number" name="jumlah_tamu" id="jumlah_tamu" min="1" max="{{ $homestay->kapasitas }}" value="{{ old('jumlah_tamu', 1) }}"
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                        <p class="text-xs text-[#8A9C91] mt-2">Kapasitas maksimal {{ $homestay->kapasitas }} tamu.</p>
                        @error('jumlah_tamu')
                            <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-[#2C3E35] mb-2">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="4"
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none"
                            placeholder="Opsional, misalnya jam kedatangan atau permintaan khusus.">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-4 px-4 rounded-xl shadow-sm transition-all">
                        Buat Booking
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <div class="aspect-[4/3] overflow-hidden rounded-xl bg-[#EAF2EE]">
                    @if ($homestay->foto)
                        <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-[#8A9C91]">Homestay</div>
                    @endif
                </div>
                <div>
                    <h3 class="font-serif text-xl font-semibold text-[#2C3E35]">{{ $homestay->nama_homestay }}</h3>
                    <p class="text-xs text-[#8A9C91] mt-1">{{ $homestay->kategori->nama_kategori ?? 'Standard' }} - {{ $homestay->kapasitas }} tamu</p>
                </div>
                <div class="border-t border-[#F2F0EA] pt-4 flex justify-between gap-4">
                    <span class="text-sm text-[#8A9C91]">Harga per malam</span>
                    <span class="font-bold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
