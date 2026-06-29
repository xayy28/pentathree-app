@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 shadow-sm">
        <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Laporan & Analitik</h1>
        <p class="text-sm text-[#5C6E65] leading-relaxed mb-6">
            Modul laporan menjadi prioritas Sprint 7. Untuk sementara, admin dapat memakai dashboard, daftar pembayaran, dan daftar reservasi sebagai sumber pengecekan transaksi.
        </p>

        <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Rencana Laporan Sprint 7</h3>
            <p class="text-xs text-[#8A9C91] max-w-sm">
                Fokus berikutnya adalah ringkasan pendapatan, penjualan souvenir, reservasi homestay, filter tanggal, dan data dashboard yang lebih lengkap.
            </p>
        </div>
    </div>
</div>
@endsection
