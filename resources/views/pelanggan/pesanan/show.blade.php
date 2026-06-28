@extends('layouts.user')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('user.pesanan.index') }}" class="text-xs font-semibold text-[#5C6E65] hover:text-[#2B4C3F]">
                    &larr; Kembali ke Riwayat
                </a>
                <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-3">
                    Detail Pesanan
                </h2>
            </div>
            <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-[#EAF2EE] text-[#2B4C3F] self-start sm:self-auto">
                {{ str_replace('_', ' ', $pemesanan->status_pemesanan) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <div class="border-b border-[#F2F0EA] pb-4 mb-5">
                    <div class="font-mono text-sm font-bold text-[#2B4C3F]">{{ $pemesanan->kode_pemesanan }}</div>
                    <div class="text-xs text-[#8A9C91] mt-1">
                        Dibuat pada {{ $pemesanan->tanggal_pemesanan->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($pemesanan->detailPemesanans as $detail)
                        <div class="flex items-center gap-4 border-b border-[#F2F0EA] pb-4 last:border-0 last:pb-0">
                            <div class="w-16 h-16 bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40 rounded-lg overflow-hidden">
                                @if ($detail->souvenir?->foto)
                                    <img src="{{ asset($detail->souvenir->foto) }}" alt="{{ $detail->nama_item }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-[#8A9C91] bg-[#FAF9F6]">Item</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-[#2C3E35] truncate">{{ $detail->nama_item }}</h3>
                                <p class="text-xs text-[#8A9C91] mt-1">
                                    {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right font-semibold text-[#2B4C3F]">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <h3 class="font-serif text-xl font-semibold text-[#2C3E35] border-b border-[#F2F0EA] pb-4">
                    Ringkasan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Jenis</span>
                        <span class="font-semibold text-[#2C3E35] capitalize">{{ $pemesanan->jenis_pemesanan }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Pembayaran</span>
                        <span class="font-semibold text-[#2C3E35]">
                            {{ $pemesanan->pembayaran ? str_replace('_', ' ', $pemesanan->pembayaran->status_pembayaran) : 'belum dibayar' }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Jumlah Item</span>
                        <span class="font-semibold text-[#2C3E35]">{{ $pemesanan->detailPemesanans->sum('jumlah') }}</span>
                    </div>
                    <div class="flex justify-between gap-4 border-t border-[#F2F0EA] pt-4">
                        <span class="font-bold text-[#2C3E35]">Total</span>
                        <span class="font-bold text-[#E65F5F]">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if (! $pemesanan->pembayaran || $pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_DITOLAK)
                    <a href="{{ route('user.pembayaran.create', $pemesanan->pemesanan_id) }}"
                        class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center">
                        Bayar Sekarang
                    </a>
                @elseif ($pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_VERIFIKASI)
                    <p class="text-[11px] leading-relaxed text-[#8A9C91] bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4">
                        Bukti pembayaran sudah dikirim dan sedang menunggu verifikasi admin.
                    </p>
                @elseif ($pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_TERVERIFIKASI)
                    <p class="text-[11px] leading-relaxed text-[#2B4C3F] bg-[#EAF2EE] border border-[#A7C5B5] rounded-xl p-4">
                        Pembayaran sudah terverifikasi. Pesanan sedang diproses.
                    </p>
                @endif

                @if ($pemesanan->pembayaran?->catatan_admin)
                    <p class="text-[11px] leading-relaxed text-[#9B1C1C] bg-[#FDF2F2] border border-[#F5C2C2] rounded-xl p-4">
                        Catatan admin: {{ $pemesanan->pembayaran->catatan_admin }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
