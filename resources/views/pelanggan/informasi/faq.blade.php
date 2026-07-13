@extends('layouts.user')

@section('title', 'FAQ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#8A9C91] mb-8">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2B4C3F] transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-[#1E362C] font-semibold">FAQ</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-10 h-10 rounded-xl bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F] flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl text-[#1E362C] font-semibold">Pertanyaan Umum (FAQ)</h1>
                <p class="text-xs text-[#8A9C91] mt-0.5">Jawaban atas pertanyaan yang sering ditanyakan</p>
            </div>
        </div>
    </div>

    {{-- FAQ List --}}
    <div class="space-y-3" id="faq-list">
        @php
            $faqs = [
                ['q' => 'Bagaimana cara memesan homestay di Natasha Homestay?', 'a' => 'Anda dapat memesan homestay dengan cara mendaftar akun terlebih dahulu, lalu memilih homestay yang tersedia, menentukan tanggal menginap, dan melakukan pembayaran. Setelah pembayaran terverifikasi, Anda akan menerima konfirmasi pemesanan.'],
                ['q' => 'Metode pembayaran apa saja yang diterima?', 'a' => 'Kami menerima pembayaran melalui Midtrans (transfer bank, kartu kredit/debit, GoPay, OVO, Dana, dan lainnya). Semua transaksi diproses secara aman melalui payment gateway Midtrans.'],
                ['q' => 'Apakah bisa membatalkan pesanan?', 'a' => 'Pembatalan dapat dilakukan selama status pesanan masih "Menunggu Pembayaran" atau "Dikonfirmasi". Pembatalan yang dilakukan setelah pembayaran terverifikasi tidak akan mendapatkan pengembalian dana otomatis. Silakan hubungi admin untuk penyelesaian lebih lanjut.'],
                ['q' => 'Bagaimana cara membeli souvenir?', 'a' => 'Anda dapat menambahkan souvenir ke keranjang belanja, lalu melakukan checkout. Pilih metode pembayaran yang tersedia, lalu lakukan pembayaran. Setelah pembayaran terverifikasi, pesanan souvenir Anda akan diproses.'],
                ['q' => 'Bagaimana cara memberikan ulasan?', 'a' => 'Setelah pesanan Anda selesai, Anda dapat memberikan ulasan dan rating pada halaman detail pesanan. Klik tombol "Beri Ulasan" pada item yang sudah selesai.'],
                ['q' => 'Apakah saya perlu verifikasi email?', 'a' => 'Ya, verifikasi email diperlukan untuk melakukan booking homestay dan pembayaran. Anda akan menerima email verifikasi setelah mendaftar.'],
                ['q' => 'Bagaimana cara menghubungi admin?', 'a' => 'Anda dapat menghubungi admin melalui WhatsApp di +62 823-8470-3440 atau email ke natashahomestay.harau@gmail.com. Admin tersedia setiap hari pada jam operasional.'],
            ];
        @endphp

        @foreach ($faqs as $i => $faq)
            <div class="faq-item bg-white border border-[#E6E4DD] rounded-2xl overflow-hidden hover:border-[#A7C5B5] transition-colors" data-index="{{ $i }}">
                <button onclick="toggleFaq({{ $i }})" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left group cursor-pointer">
                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-lg bg-[#EAF2EE] text-[#2B4C3F] text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-[#2B4C3F] group-hover:text-white transition-colors">{{ $i + 1 }}</span>
                        <span class="text-sm font-semibold text-[#1E362C] leading-relaxed">{{ $faq['q'] }}</span>
                    </div>
                    <svg class="faq-chevron w-5 h-5 text-[#8A9C91] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-answer px-6 pb-5">
                    <div class="pl-10 text-sm text-[#5C6E65] leading-relaxed">{{ $faq['a'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<style>
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.35s ease; }
    .faq-answer.open { max-height: 500px; }
    .faq-chevron { transition: transform 0.3s ease; }
    .faq-item.active .faq-chevron { transform: rotate(180deg); }
</style>
<script>
    function toggleFaq(index) {
        const item = document.querySelector(`.faq-item[data-index="${index}"]`);
        const answer = item.querySelector('.faq-answer');
        const isOpen = item.classList.contains('active');

        document.querySelectorAll('.faq-item').forEach(el => {
            el.classList.remove('active');
            el.querySelector('.faq-answer').classList.remove('open');
        });

        if (!isOpen) {
            item.classList.add('active');
            answer.classList.add('open');
        }
    }
</script>
@endpush
@endsection
