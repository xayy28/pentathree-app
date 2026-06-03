@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 shadow-sm">
        <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Kelola Pembayaran</h1>
        <p class="text-sm text-[#5C6E65] leading-relaxed mb-6">
            Halaman pengelolaan Pembayaran sedang dalam pengembangan untuk Project Base Learning (PBL).
        </p>
        
        <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl flex flex-col items-center justify-center text-center">
            <span class="text-5xl mb-4">💳</span>
            <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Fitur Pembayaran Belum Tersedia</h3>
            <p class="text-xs text-[#8A9C91] max-w-sm">
                Anda dapat menambahkan form konfirmasi pembayaran, upload bukti transfer bank, atau integrasi Payment Gateway di sini.
            </p>
        </div>
    </div>
</div>
@endsection
