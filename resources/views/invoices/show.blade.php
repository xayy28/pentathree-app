@extends(auth()->user()->role === 'admin' ? 'layouts.app' : 'layouts.user')

@section('title', 'Invoice')

@section('content')
    @php
        $pemesanan = $invoice->pemesanan;
        $pembayaran = $invoice->pembayaran ?? $pemesanan->pembayaran;
        $isAdmin = auth()->user()->role === 'admin';
        $tanggalPembayaran = $pembayaran?->paid_at ?? $pembayaran?->verified_at ?? $pembayaran?->tanggal_pembayaran;
    @endphp

    <style>
        /* no print styles needed — use PDF route for printing */
    </style>

    <div class="invoice-shell max-w-4xl mx-auto {{ $isAdmin ? '' : 'px-4 sm:px-6 lg:px-8 py-10' }}">
        <div class="no-print mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            @include('components.back-link', ['href' => $backRoute, 'label' => $backLabel])
            <div class="flex items-center gap-3">
                @if ($isAdmin)
                    <a href="{{ route('admin.invoices.pdf', $invoice->invoice_id) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#2B4C3F] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1E362C] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh PDF
                    </a>
                @else
                    <a href="{{ route('user.invoices.pdf', $invoice->pemesanan_id) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#2B4C3F] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1E362C] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh PDF
                    </a>
                @endif
            </div>
        </div>

        <div class="invoice-paper bg-white rounded-lg border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 border-b-2 border-[#2B4C3F] pb-5">
                <div>
                    <p class="text-[11px] font-bold uppercase text-[#8A9C91]">Invoice</p>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-bold text-[#1E362C]">{{ $invoice->nomor_invoice }}</h1>
                    <p class="mt-2 text-sm font-semibold text-[#2C3E35]">Natasha Homestay & Harau Souvenir</p>
                </div>
                <div class="text-sm sm:text-right text-[#2C3E35]">
                    <div class="font-semibold">{{ $invoice->tanggal_invoice->format('d M Y') }}</div>
                    <div class="mt-1 text-[#5C6E65]">{{ $invoice->tanggal_invoice->format('H:i') }} WIB</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 text-sm">
                <section>
                    <h2 class="text-[11px] font-bold uppercase text-[#8A9C91] mb-3">Customer</h2>
                    <div class="space-y-1.5 text-[#2C3E35]">
                        <div class="font-bold">{{ $pemesanan->user->nama }}</div>
                        <div>{{ $pemesanan->user->no_hp ?? '-' }}</div>
                        <div>{{ $pemesanan->user->email }}</div>
                    </div>
                </section>

                <section class="sm:text-right">
                    <h2 class="text-[11px] font-bold uppercase text-[#8A9C91] mb-3">Pesanan</h2>
                    <div class="space-y-1.5 text-[#2C3E35]">
                        <div><span class="text-[#8A9C91]">Kode:</span> <span class="font-mono font-bold">{{ $pemesanan->kode_pemesanan }}</span></div>
                        <div><span class="text-[#8A9C91]">Jenis:</span> <span class="font-semibold capitalize">{{ $pemesanan->jenis_pemesanan }}</span></div>
                        <div><span class="text-[#8A9C91]">Bayar:</span> <span class="font-semibold">{{ $pembayaran ? ucwords(str_replace('_', ' ', $pembayaran->metode_pembayaran)) : '-' }}</span></div>
                        @if($tanggalPembayaran)
                            <div><span class="text-[#8A9C91]">Tanggal Bayar:</span> {{ $tanggalPembayaran->format('d M Y') }}</div>
                        @endif
                    </div>
                </section>
            </div>

            <div class="overflow-x-auto border border-[#E6E4DD] rounded-lg">
                <table class="w-full min-w-[620px] text-sm">
                    <thead class="bg-[#F7F6F2] text-[11px] uppercase text-[#5C6E65]">
                        <tr>
                            <th class="px-4 py-3 text-left">Deskripsi</th>
                            <th class="px-4 py-3 text-center w-32">Qty / Durasi</th>
                            <th class="px-4 py-3 text-right w-36">Harga</th>
                            <th class="px-4 py-3 text-right w-36">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @foreach($pemesanan->detailPemesanans as $detail)
                            <tr>
                                <td class="px-4 py-4 align-top">
                                    <div class="font-semibold">{{ $detail->nama_item }}</div>
                                    @if($detail->homestay_id && $detail->check_in && $detail->check_out)
                                        <div class="mt-1 text-xs text-[#5C6E65]">
                                            {{ $detail->check_in->format('d M Y') }} - {{ $detail->check_out->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 align-top text-center">
                                    @if($detail->homestay_id)
                                        {{ $detail->jumlah_malam }} malam
                                    @else
                                        {{ $detail->jumlah }} item
                                    @endif
                                </td>
                                <td class="px-4 py-4 align-top text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 align-top text-right font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <div class="w-full sm:w-80 text-sm">
                    <div class="flex justify-between gap-4 border-b border-[#E6E4DD] py-3">
                        <span class="text-[#5C6E65]">Total Pesanan</span>
                        <span class="font-semibold text-[#2C3E35]">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between gap-4 py-4 text-base">
                        <span class="font-bold text-[#1E362C]">Total Tagihan</span>
                        <span class="font-bold text-[#E65F5F]">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-[#E6E4DD] pt-4 text-xs text-[#5C6E65] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div><span class="font-semibold text-[#2C3E35]">Status invoice:</span> {{ ucfirst($invoice->status_invoice) }}</div>
                <div>Dokumen diterbitkan otomatis setelah pembayaran terverifikasi.</div>
            </div>
        </div>
    </div>
@endsection
