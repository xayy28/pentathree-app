@extends('layouts.user')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="bg-white rounded-[32px] border border-gray-200/60 p-8 sm:p-12 shadow-sm">
        <h1 class="text-3xl font-serif font-semibold text-[#1E362C] mb-2">Riwayat Reservasi</h1>
        <p class="text-sm text-[#5C6E65] leading-relaxed mb-6">
            Reservasi homestay sekarang dipantau bersama riwayat pesanan agar status souvenir dan homestay tetap konsisten.
        </p>

        <div class="p-8 sm:p-12 bg-[#F3F4F6] border border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-[#1E362C] mb-1">Buka Riwayat Pesanan</h3>
            <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                Semua booking homestay yang sudah dibuat akan muncul di halaman riwayat pesanan.
            </p>
            <a href="{{ route('user.pesanan.index') }}"
                class="inline-flex items-center justify-center bg-[#1E362C] hover:bg-[#152720] text-white text-xs font-semibold py-3 px-6 rounded-xl shadow-sm transition-all">
                Lihat Riwayat
            </a>
        </div>
    </div>
</div>
@endsection
