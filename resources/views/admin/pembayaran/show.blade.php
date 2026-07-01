@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.pembayaran') }}" class="text-xs font-semibold text-[#5C6E65] hover:text-[#2B4C3F]">
                    &larr; Kembali ke Pembayaran
                </a>
                <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mt-3">Detail Pembayaran</h1>
            </div>
            <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-[#EAF2EE] text-[#2B4C3F]">
                {{ str_replace('_', ' ', $pembayaran->status_pembayaran) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-6">
                <div class="border-b border-[#F2F0EA] pb-4">
                    <div class="font-mono text-sm font-bold text-[#2B4C3F]">{{ $pembayaran->pemesanan->kode_pemesanan }}</div>
                    <div class="text-xs text-[#8A9C91] mt-1">
                        {{ $pembayaran->pemesanan->user->nama }} · {{ $pembayaran->tanggal_pembayaran->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Jumlah Bayar</div>
                        <div class="font-bold text-[#2C3E35]">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Total Pesanan</div>
                        <div class="font-bold text-[#2C3E35]">Rp {{ number_format($pembayaran->pemesanan->total_harga, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Metode</div>
                        <div class="font-semibold text-[#2C3E35]">{{ str_replace('_', ' ', $pembayaran->metode_pembayaran) }}</div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Verifier</div>
                        <div class="font-semibold text-[#2C3E35]">{{ $pembayaran->verifier?->nama ?? '-' }}</div>
                    </div>
                    @if ($pembayaran->metode_pembayaran === 'midtrans')
                        <div>
                            <div class="text-[#8A9C91] text-xs mb-1">Midtrans Order ID</div>
                            <div class="font-mono text-xs font-semibold text-[#2C3E35] break-all">{{ $pembayaran->midtrans_order_id ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[#8A9C91] text-xs mb-1">Status Gateway</div>
                            <div class="font-semibold text-[#2C3E35]">{{ $pembayaran->midtrans_transaction_status ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[#8A9C91] text-xs mb-1">Payment Type</div>
                            <div class="font-semibold text-[#2C3E35]">{{ $pembayaran->midtrans_payment_type ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[#8A9C91] text-xs mb-1">VA / Kode Bayar</div>
                            <div class="font-mono text-xs font-semibold text-[#2C3E35]">{{ $pembayaran->midtrans_va_number ?? $pembayaran->midtrans_payment_code ?? '-' }}</div>
                        </div>
                    @endif
                </div>

                <div>
                    <h2 class="font-serif text-lg font-semibold text-[#2C3E35] mb-4">Item Pesanan</h2>
                    <div class="space-y-3">
                        @foreach ($pembayaran->pemesanan->detailPemesanans as $detail)
                            <div class="flex items-center justify-between gap-4 border border-[#F2F0EA] rounded-xl p-4">
                                <div>
                                    <div class="font-semibold text-[#2C3E35]">{{ $detail->nama_item }}</div>
                                    <div class="text-xs text-[#8A9C91] mt-1">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-bold text-[#2B4C3F]">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($pembayaran->catatan_admin)
                    <div class="p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl text-sm text-[#5C6E65]">
                        <span class="font-bold text-[#2C3E35]">Catatan Admin:</span> {{ $pembayaran->catatan_admin }}
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <h2 class="font-serif text-lg font-semibold text-[#2C3E35]">Bukti Pembayaran</h2>
                @if ($pembayaran->bukti_pembayaran)
                    <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                            class="w-full rounded-xl border border-[#E6E4DD] object-cover">
                    </a>
                @else
                    <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl text-center text-xs text-[#8A9C91]">
                        {{ $pembayaran->metode_pembayaran === 'midtrans' ? 'Pembayaran diproses otomatis melalui Midtrans.' : 'Tidak ada bukti pembayaran.' }}
                    </div>
                @endif

                @if ($pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_VERIFIKASI)
                    <form action="{{ route('admin.pembayaran.verify', $pembayaran->pembayaran_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                            Verifikasi Pembayaran
                        </button>
                    </form>

                    <form action="{{ route('admin.pembayaran.reject', $pembayaran->pembayaran_id) }}" method="POST" class="space-y-3">
                        @csrf
                        <textarea name="catatan_admin" rows="3" placeholder="Catatan penolakan..."
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none"></textarea>
                        <button type="submit"
                            class="w-full bg-[#FDF2F2] hover:bg-[#F8DADA] text-[#B91C1C] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                            Tolak Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
