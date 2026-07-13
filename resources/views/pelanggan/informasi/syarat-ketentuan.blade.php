@extends('layouts.user')

@section('title', 'Syarat & Ketentuan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#8A9C91] mb-8">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2B4C3F] transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-[#1E362C] font-semibold">Syarat & Ketentuan</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-10 h-10 rounded-xl bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Syarat & Ketentuan</h1>
                <p class="text-xs text-[#8A9C91] mt-0.5">Terakhir diperbarui: Januari 2026</p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-white border border-[#E6E4DD] rounded-2xl p-6 sm:p-8 space-y-6">
        <div class="text-sm text-[#5C6E65] leading-relaxed space-y-5">
            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">1. Penerimaan Syarat</h2>
                <p>Dengan mengakses dan menggunakan situs serta layanan Natasha Homestay, Anda setuju untuk terikat dengan syarat dan ketentuan ini. Jika Anda tidak setuju, mohon untuk tidak menggunakan layanan kami.</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">2. Pendaftaran Akun</h2>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Anda harus berusia minimal 17 tahun atau memiliki persetujuan orang tua/wali.</li>
                    <li>Informasi yang diberikan harus akurat dan terkini.</li>
                    <li>Anda bertanggung jawab atas keamanan akun Anda.</li>
                    <li>Satu akun per pengguna. Dilarang membuat akun ganda.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">3. Pemesanan & Pembayaran</h2>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Semua pemesanan bergantung pada ketersediaan.</li>
                    <li>Harga yang tercantum sudah termasuk pajak yang berlaku.</li>
                    <li>Pembayaran harus dilakukan dalam waktu yang ditentukan. Pesanan akan otomatis dibatalkan jika pembayaran tidak diterima tepat waktu.</li>
                    <li>Pembayaran diproses melalui payment gateway Midtrans yang aman dan terenkripsi.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">4. Pembatalan & Pengembalian Dana</h2>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Pembatalan dapat dilakukan selama status pesanan masih dalam proses (belum terverifikasi).</li>
                    <li>Pembatalan setelah pembayaran terverifikasi tidak otomatis mendapatkan pengembalian dana.</li>
                    <li>Pengembalian dana (jika disetujui) akan diproses dalam 3-7 hari kerja.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">5. Check-in & Check-out Homestay</h2>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Waktu check-in: 14:00 WIB</li>
                    <li>Waktu check-out: 12:00 WIB</li>
                    <li>Check-in lebih awal atau check-out lebih lama dapat dikenakan biaya tambahan (tergantung ketersediaan).</li>
                    <li>Tamu wajib menunjukkan bukti pemesanan saat check-in.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">6. Pelanggan & Perilaku</h2>
                <ul class="list-disc list-inside mt-2 space-y-1 text-[#8A9C91]">
                    <li>Pelanggan wajib menjaga kebersihan dan ketertiban selama menginap.</li>
                    <li>Dilarang melakukan aktivitas ilegal atau merusak properti.</li>
                    <li>Kerusakan properti akan dikenakan biaya penggantian.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">7. Harga & Perubahan</h2>
                <p>Natasha Homestay berhak mengubah harga dan ketentuan sewaktu-waktu tanpa pemberitahuan sebelumnya. Harga yang berlaku adalah harga yang tertera pada saat pemesanan dilakukan.</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">8. Batasan Tanggung Jawab</h2>
                <p>Natasha Homestay tidak bertanggung jawab atas kerugian tidak langsung, kehilangan data, atau kerusakan yang timbul dari penggunaan layanan kami. Layanan disediakan "sebagaimana adanya".</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">9. Hukum yang Berlaku</h2>
                <p>Syarat dan ketentuan ini tunduk pada hukum Negara Kesatuan Republik Indonesia. Setiap sengketa akan diselesaikan melalui musyawarah terlebih dahulu.</p>
            </div>

            <div>
                <h2 class="font-semibold text-[#1E362C] mb-2">10. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan terkait syarat dan ketentuan ini, silakan hubungi kami melalui WhatsApp di +62 823-8470-3440 atau email ke natashahomestay.harau@gmail.com.</p>
            </div>
        </div>
    </div>
</div>
@endsection
