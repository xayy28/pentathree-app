@extends('layouts.user')

@section('title', 'Buat Reservasi')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="bg-white rounded-[32px] border border-gray-200/60 p-8 sm:p-12 shadow-sm">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('user.homestay') }}" class="text-[#8A9C91] hover:text-[#1E362C] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8A9C91] block">Natasha Retreat</span>
                <h1 class="text-2xl font-serif font-semibold text-[#1E362C]">Buat Reservasi</h1>
            </div>
        </div>

        <div class="flex gap-4 p-4 bg-[#EAF2EE] rounded-2xl mb-6">
            @if($homestay->foto)
                <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-24 h-20 object-cover rounded-xl flex-shrink-0">
            @else
                <div class="w-24 h-20 bg-[#B8DEC8] rounded-xl flex-shrink-0 flex items-center justify-center text-[#1E362C] font-semibold">
                    Home
                </div>
            @endif
            <div class="space-y-1">
                <h3 class="font-serif font-semibold text-lg text-[#1E362C]">{{ $homestay->nama_homestay }}</h3>
                <p class="text-xs text-[#5C6E65]">Kapasitas: {{ $homestay->kapasitas }} Orang &bull; {{ $homestay->kategori->nama_kategori ?? 'Standard' }}</p>
                <p class="text-sm font-bold text-[#1E362C]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}<span class="text-xs font-normal text-[#8A9C91]">/malam</span></p>
            </div>
        </div>

        <div class="p-8 bg-[#F3F4F6] border border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-[#1E362C] mb-1">Gunakan Form Booking Homestay</h3>
            <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                Isi tanggal check-in, check-out, dan jumlah tamu melalui flow booking aktif.
            </p>
            <a href="{{ route('user.homestay.booking.create', $homestay->homestay_id) }}"
                class="inline-flex items-center justify-center bg-[#1E362C] hover:bg-[#152720] text-white text-xs font-semibold py-3 px-6 rounded-xl shadow-sm transition-all">
                Lanjut Booking
            </a>
        </div>
    </div>
</div>
@endsection
