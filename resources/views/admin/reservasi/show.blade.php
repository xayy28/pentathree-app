@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
    @php
        $statusLabels = \App\Models\Pemesanan::homestayStatusLabels();
        $detail = $reservasi->detailPemesanans->first();
        $paymentWaitingVerification = $reservasi->pembayaran?->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_VERIFIKASI;
        $paymentVerified = $reservasi->pembayaran?->status_pembayaran === \App\Models\Pembayaran::STATUS_TERVERIFIKASI;
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                @include('components.back-link', ['href' => route('admin.reservasi'), 'label' => 'Kembali ke Reservasi'])
                <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mt-3">Detail Reservasi</h1>
            </div>
            <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-[#EAF2EE] text-[#2B4C3F]">
                {{ $statusLabels[$reservasi->status_pemesanan] ?? str_replace('_', ' ', $reservasi->status_pemesanan) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-6">
                <div class="border-b border-[#F2F0EA] pb-4">
                    <div class="font-mono text-sm font-bold text-[#2B4C3F]">{{ $reservasi->kode_pemesanan }}</div>
                    <div class="text-xs text-[#8A9C91] mt-1">
                        {{ $reservasi->user->nama }} - {{ $reservasi->tanggal_pemesanan->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Pelanggan</div>
                        <div class="font-bold text-[#2C3E35]">{{ $reservasi->user->nama }}</div>
                        <div class="text-xs text-[#8A9C91] mt-1">{{ $reservasi->user->email }}</div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Total Reservasi</div>
                        <div class="font-bold text-[#2C3E35]">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Status Pembayaran</div>
                        <div class="font-semibold text-[#2C3E35]">
                            {{ $reservasi->pembayaran ? str_replace('_', ' ', $reservasi->pembayaran->status_pembayaran) : '-' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-[#8A9C91] text-xs mb-1">Metode Pembayaran</div>
                        <div class="font-semibold text-[#2C3E35]">
                            {{ $reservasi->pembayaran ? str_replace('_', ' ', $reservasi->pembayaran->metode_pembayaran) : '-' }}
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="font-serif text-lg font-semibold text-[#2C3E35] mb-4">Data Homestay</h2>
                    <div class="border border-[#F2F0EA] rounded-xl p-4">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <div class="font-semibold text-[#2C3E35]">{{ $detail?->nama_item ?? '-' }}</div>
                                <div class="text-xs text-[#8A9C91] mt-1">
                                    {{ $detail?->jumlah_malam ?? 0 }} malam
                                    @if ($detail?->check_in && $detail?->check_out)
                                        - {{ $detail->check_in->format('d M Y') }} sampai {{ $detail->check_out->format('d M Y') }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-left sm:text-right">
                                <div class="font-bold text-[#2B4C3F]">Rp {{ number_format($detail?->subtotal ?? 0, 0, ',', '.') }}</div>
                                <div class="text-xs text-[#8A9C91] mt-1">Rp {{ number_format($detail?->harga ?? 0, 0, ',', '.') }} / malam</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <h2 class="font-serif text-lg font-semibold text-[#2C3E35]">Ubah Status</h2>
                <p class="text-xs text-[#8A9C91] leading-relaxed">
                    Ikuti alur operasional reservasi dari konfirmasi pembayaran sampai tamu check-out.
                </p>

                @if ($reservasi->pembayaran?->bukti_pembayaran)
                    <div>
                        <h3 class="text-sm font-semibold text-[#2C3E35] mb-3">Bukti Pembayaran</h3>
                        <a href="{{ asset('storage/' . $reservasi->pembayaran->bukti_pembayaran) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $reservasi->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                class="w-full rounded-xl border border-[#E6E4DD] object-cover">
                        </a>
                    </div>
                @elseif ($reservasi->pembayaran?->metode_pembayaran === 'midtrans')
                    <div class="p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl text-xs text-[#8A9C91] leading-relaxed">
                        Pembayaran diproses otomatis melalui Midtrans. Gunakan status gateway sebelum mengubah status reservasi.
                    </div>
                @endif

                @if ($reservasi->invoice)
                    <a href="{{ route('admin.invoices.show', $reservasi->invoice->invoice_id) }}"
                        class="w-full border border-[#C9D8D0] bg-white hover:bg-[#F3F7F5] text-[#2B4C3F] text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center">
                        Lihat Invoice
                    </a>
                @endif

                <div class="space-y-3">
                    @if ($paymentWaitingVerification)
                        <form action="{{ route('admin.reservasi.verify-payment', $reservasi->pemesanan_id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                                Verifikasi Pembayaran & Konfirmasi Booking
                            </button>
                        </form>

                        <form action="{{ route('admin.reservasi.reject-payment', $reservasi->pemesanan_id) }}" method="POST" class="space-y-3">
                            @csrf
                            <textarea name="catatan_admin" rows="3" placeholder="Catatan penolakan..."
                                class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none"></textarea>
                            <button type="submit"
                                class="w-full bg-[#FDF2F2] hover:bg-[#F8DADA] text-[#B91C1C] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                                Tolak Pembayaran
                            </button>
                        </form>
                    @endif

                    @if ($paymentVerified)
                        <form action="{{ route('admin.reservasi.status', $reservasi->pemesanan_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status_pemesanan" value="{{ \App\Models\Pemesanan::STATUS_DIKONFIRMASI }}">
                            <button type="submit"
                                class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                                Konfirmasi Booking
                            </button>
                        </form>

                        <form action="{{ route('admin.reservasi.status', $reservasi->pemesanan_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status_pemesanan" value="{{ \App\Models\Pemesanan::STATUS_SEDANG_MENGINAP }}">
                            <button type="submit"
                                class="w-full bg-[#EAF2EE] hover:bg-[#DDEBE4] text-[#2B4C3F] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                                Check-in / Sedang Menginap
                            </button>
                        </form>

                        <form action="{{ route('admin.reservasi.status', $reservasi->pemesanan_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status_pemesanan" value="{{ \App\Models\Pemesanan::STATUS_SELESAI }}">
                            <button type="submit"
                                class="w-full bg-[#F3F7F5] hover:bg-[#EAF2EE] text-[#2B4C3F] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                                Tandai Check-out / Selesai
                            </button>
                        </form>
                    @else
                        <p class="text-[11px] leading-relaxed text-[#8A5A10] bg-[#FFF8E8] border border-[#F2D8A8] rounded-xl p-4">
                            Konfirmasi, check-in, dan selesai aktif setelah pembayaran terverifikasi.
                        </p>
                    @endif

                    <form action="{{ route('admin.reservasi.status', $reservasi->pemesanan_id) }}" method="POST"
                        onsubmit="return confirm('Batalkan reservasi ini?')">
                        @csrf
                        <input type="hidden" name="status_pemesanan" value="{{ \App\Models\Pemesanan::STATUS_DIBATALKAN }}">
                        <button type="submit"
                            class="w-full bg-[#FDF2F2] hover:bg-[#F8DADA] text-[#B91C1C] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                            Batalkan Reservasi
                        </button>
                    </form>

                    <form action="{{ route('admin.reservasi.status', $reservasi->pemesanan_id) }}" method="POST"
                        onsubmit="return confirm('Tandai reservasi ini sebagai kedaluwarsa?')">
                        @csrf
                        <input type="hidden" name="status_pemesanan" value="{{ \App\Models\Pemesanan::STATUS_KEDALUWARSA }}">
                        <button type="submit"
                            class="w-full bg-[#F8F7F4] hover:bg-[#F2F0EA] text-[#5C6E65] text-sm font-semibold py-3 px-4 rounded-xl transition-all">
                            Tandai Kedaluwarsa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
