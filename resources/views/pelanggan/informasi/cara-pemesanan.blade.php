@extends('layouts.user')

@section('title', 'Cara Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#8A9C91] mb-8">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2B4C3F] transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-[#1E362C] font-semibold">Cara Pemesanan</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-10 h-10 rounded-xl bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </span>
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Cara Pemesanan</h1>
                <p class="text-xs text-[#8A9C91] mt-0.5">Langkah-langkah mudah untuk memesan</p>
            </div>
        </div>
    </div>

    {{-- Booking Homestay --}}
    <div class="mb-12">
        <h2 class="text-sm font-bold text-[#2B4C3F] uppercase tracking-wider mb-6 flex items-center gap-2">
            <span class="w-7 h-7 rounded-full bg-[#2B4C3F] text-white text-[11px] flex items-center justify-center">🏠</span>
            Booking Homestay
        </h2>
        <div class="space-y-0">
            @php
                $homestaySteps = [
                    ['title' => 'Daftar / Masuk Akun', 'desc' => 'Buat akun baru atau masuk ke akun yang sudah ada. Verifikasi email Anda terlebih dahulu.'],
                    ['title' => 'Pilih Homestay', 'desc' => 'Jelajahi katalog homestay, lihat detail harga, fasilitas, dan ketersediaan tanggal.'],
                    ['title' => 'Isi Formulir Booking', 'desc' => 'Pilih tanggal check-in dan check-out, masukkan jumlah tamu, serta catatan khusus jika ada.'],
                    ['title' => 'Lakukan Pembayaran', 'desc' => 'Pilih metode pembayaran yang tersedia (transfer bank, e-wallet, kartu). Bayar sesuai total yang tertera.'],
                    ['title' => 'Konfirmasi & Selesai', 'desc' => 'Admin akan memverifikasi pembayaran Anda. Pesanan akan dikonfirmasi dan Anda menerima bukti pemesanan.'],
                ];
            @endphp

            @foreach ($homestaySteps as $step)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-9 h-9 rounded-full bg-[#2B4C3F] text-white text-xs font-bold flex items-center justify-center z-10">{{ $loop->iteration }}</span>
                        @if (!$loop->last)
                            <div class="w-px flex-1 bg-[#E6E4DD] my-1"></div>
                        @endif
                    </div>
                    <div class="pb-6 pt-1.5">
                        <h3 class="text-sm font-semibold text-[#1E362C]">{{ $step['title'] }}</h3>
                        <p class="text-xs text-[#8A9C91] mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Beli Souvenir --}}
    <div>
        <h2 class="text-sm font-bold text-[#2B4C3F] uppercase tracking-wider mb-6 flex items-center gap-2">
            <span class="w-7 h-7 rounded-full bg-[#2B4C3F] text-white text-[11px] flex items-center justify-center">🛍️</span>
            Beli Souvenir
        </h2>
        <div class="space-y-0">
            @php
                $souvenirSteps = [
                    ['title' => 'Pilih Souvenir', 'desc' => 'Jelajahi katalog souvenir, lihat harga, stok, dan deskripsi produk.'],
                    ['title' => 'Tambah ke Keranjang', 'desc' => 'Klik tombol "Tambah ke Keranjang" pada souvenir yang diinginkan. Atau langsung beli (Buy Now).'],
                    ['title' => 'Checkout', 'desc' => 'Review pesanan di keranjang, pastikan jumlah dan total harga sudah benar, lalu klik Checkout.'],
                    ['title' => 'Pilih Metode Pembayaran', 'desc' => 'Pilih metode pembayaran yang diinginkan dan lakukan pembayaran sesuai petunjuk.'],
                    ['title' => 'Pesanan Diproses', 'desc' => 'Admin akan memverifikasi dan memproses pesanan Anda. Anda dapat melihat status pesanan di halaman "Pesanan".'],
                ];
            @endphp

            @foreach ($souvenirSteps as $step)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-9 h-9 rounded-full bg-[#2B4C3F] text-white text-xs font-bold flex items-center justify-center z-10">{{ $loop->iteration }}</span>
                        @if (!$loop->last)
                            <div class="w-px flex-1 bg-[#E6E4DD] my-1"></div>
                        @endif
                    </div>
                    <div class="pb-6 pt-1.5">
                        <h3 class="text-sm font-semibold text-[#1E362C]">{{ $step['title'] }}</h3>
                        <p class="text-xs text-[#8A9C91] mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
