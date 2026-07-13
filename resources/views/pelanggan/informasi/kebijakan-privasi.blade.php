@extends('layouts.user')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#8A9C91] mb-8">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2B4C3F] transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-[#1E362C] font-semibold">Kebijakan Privasi</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-10 h-10 rounded-xl bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </span>
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Kebijakan Privasi</h1>
                <p class="text-xs text-[#8A9C91] mt-0.5">Terakhir diperbarui: Januari 2026</p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-white border border-[#E6E4DD] rounded-2xl p-6 sm:p-8 space-y-6">
        <div class="text-sm text-[#5C6E65] leading-relaxed space-y-5">
            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">1. Informasi yang Kami Kumpulkan</h2>
                <p>Kami mengumpulkan informasi pribadi yang Anda berikan saat mendaftar dan menggunakan layanan kami, termasuk:</p>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Nama lengkap dan alamat email</li>
                    <li>Nomor telepon</li>
                    <li>Informasi profil (foto profil)</li>
                    <li>Data transaksi pemesanan dan pembayaran</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">2. Penggunaan Informasi</h2>
                <p>Informasi yang dikumpulkan digunakan untuk:</p>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Memproses pemesanan homestay dan souvenir</li>
                    <li>Mengirimkan konfirmasi dan notifikasi pesanan</li>
                    <li>Memverifikasi identitas dan email Anda</li>
                    <li>Meningkatkan kualitas layanan kami</li>
                    <li>Hubungan pelanggan dan dukungan teknis</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">3. Perlindungan Data</h2>
                <p>Kami menggunakan langkah-langkah keamanan yang wajar untuk melindungi informasi pribadi Anda dari akses tidak sah, pengubahan, atau penghancuran. Data pembayaran diproses melalui payment gateway pihak ketiga (Midtrans) yang terenkripsi.</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">4. Berbagi Informasi</h2>
                <p>Kami tidak menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga. Informasi hanya dibagikan dengan pihak yang terlibat dalam pemrosesan pesanan (payment gateway, layanan notifikasi).</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">5. Hak Anda</h2>
                <p>Anda berhak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda. Untuk permintaan terkait data pribadi, silakan hubungi kami melalui email atau WhatsApp.</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">6. Cookie</h2>
                <p>Situs ini menggunakan cookie untuk meningkatkan pengalaman pengguna. Anda dapat mengatur preferensi cookie melalui browser Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection
