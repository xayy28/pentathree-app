@extends('layouts.user')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 bg-[#F8F7F4]">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
                    Riwayat Pesanan
                </h2>
                <p class="text-sm text-[#5C6E65] mt-3 max-w-2xl leading-relaxed">
                    Pantau pemesanan souvenir dan reservasi homestay yang sudah dibuat.
                </p>
            </div>
            <a href="{{ route('user.souvenir') }}"
                class="inline-flex items-center justify-center bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold py-3 px-5 rounded-xl shadow-sm transition-all">
                Belanja Souvenir
            </a>
        </div>

        @if ($pemesanans->isEmpty())
            <div class="max-w-md mx-auto bg-white rounded-3xl border border-[#E6E4DD] p-12 text-center shadow-sm">
                <h3 class="text-xl font-serif font-semibold text-[#2C3E35] mb-2">Belum Ada Pesanan</h3>
                <p class="text-xs text-[#8A9C91] mb-6 leading-relaxed">
                    Pesanan yang dibuat dari checkout akan muncul di halaman ini.
                </p>
                <a href="{{ route('user.souvenir') }}"
                    class="inline-flex items-center justify-center bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold py-3 px-6 rounded-xl shadow-sm transition-all">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach ($pemesanans as $pemesanan)
                    <a href="{{ route('user.pesanan.show', $pemesanan->pemesanan_id) }}"
                        class="bg-white rounded-2xl border border-[#E6E4DD] p-5 shadow-sm hover:shadow-md transition-all flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="font-mono text-xs font-bold text-[#2B4C3F] bg-[#EAF2EE] px-3 py-1 rounded-full">
                                    {{ $pemesanan->kode_pemesanan }}
                                </span>
                                <span class="text-[10px] uppercase tracking-wider font-bold text-[#8A9C91]">
                                    {{ $pemesanan->jenis_pemesanan }}
                                </span>
                            </div>
                            <div class="text-sm text-[#5C6E65]">
                                {{ $pemesanan->tanggal_pemesanan->format('d M Y H:i') }} · {{ $pemesanan->detail_pemesanans_count }} item
                            </div>
                        </div>
                        <div class="flex items-center justify-between lg:justify-end gap-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]">
                                {{ str_replace('_', ' ', $pemesanan->status_pemesanan) }}
                            </span>
                            <span class="text-lg font-bold text-[#2B4C3F]">
                                Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
