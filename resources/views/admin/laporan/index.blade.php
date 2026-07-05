@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    @php
        $statusLabels = [
            \App\Models\Pemesanan::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            \App\Models\Pemesanan::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            \App\Models\Pemesanan::STATUS_DIPROSES => 'Diproses',
            \App\Models\Pemesanan::STATUS_DIKONFIRMASI => 'Dikonfirmasi',
            \App\Models\Pemesanan::STATUS_SELESAI => 'Selesai',
            \App\Models\Pemesanan::STATUS_DIBATALKAN => 'Dibatalkan',
        ];
    @endphp

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 shadow-sm">
            <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5">
                <div>
                    <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Laporan & Analitik</h1>
                    <p class="text-sm text-[#5C6E65] leading-relaxed max-w-2xl">
                        Pantau pendapatan terverifikasi, penjualan souvenir, dan status reservasi homestay dari data transaksi aplikasi.
                    </p>
                </div>

                <form action="{{ route('admin.laporan') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto_auto_auto] gap-3">
                    <div>
                        <label for="date_from" class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91] mb-1">
                            Dari
                        </label>
                        <input id="date_from" type="date" name="date_from" value="{{ $dateFrom?->toDateString() }}"
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                    </div>
                    <div>
                        <label for="date_to" class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91] mb-1">
                            Sampai
                        </label>
                        <input id="date_to" type="date" name="date_to" value="{{ $dateTo?->toDateString() }}"
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                    </div>
                    <button type="submit"
                        class="self-end inline-flex h-11 min-w-[112px] items-center justify-center whitespace-nowrap bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold px-5 rounded-xl transition-all">
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan') }}"
                        class="self-end inline-flex h-11 min-w-[112px] items-center justify-center whitespace-nowrap bg-[#FAF9F6] hover:bg-[#F2F0EA] text-[#5C6E65] text-sm font-semibold px-5 rounded-xl border border-[#E6E4DD] transition-all text-center">
                        Reset
                    </a>
                    <a href="{{ route('admin.laporan.pdf', request()->only(['date_from', 'date_to'])) }}"
                        class="self-end inline-flex h-11 min-w-[112px] items-center justify-center whitespace-nowrap bg-[#B7791F] hover:bg-[#975A16] text-white text-sm font-semibold px-5 rounded-xl transition-all text-center">
                        Unduh PDF
                    </a>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Total Pendapatan</span>
                <div class="mt-3 text-2xl font-serif font-semibold text-[#2B4C3F]">
                    Rp {{ number_format((float) $summary['total_pendapatan'], 0, ',', '.') }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">{{ $summary['transaksi_terverifikasi'] }} pembayaran terverifikasi</p>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Pendapatan Souvenir</span>
                <div class="mt-3 text-2xl font-serif font-semibold text-[#2B4C3F]">
                    Rp {{ number_format((float) $summary['pendapatan_souvenir'], 0, ',', '.') }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">Dari pembayaran souvenir valid</p>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Pendapatan Homestay</span>
                <div class="mt-3 text-2xl font-serif font-semibold text-[#2B4C3F]">
                    Rp {{ number_format((float) $summary['pendapatan_homestay'], 0, ',', '.') }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">Dari pembayaran reservasi valid</p>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">Reservasi Homestay</span>
                <div class="mt-3 text-2xl font-serif font-semibold text-[#2B4C3F]">
                    {{ $summary['total_reservasi'] }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">{{ $summary['pembayaran_menunggu'] }} pembayaran menunggu verifikasi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-xl font-serif font-semibold text-[#2C3E35]">Penjualan Souvenir</h2>
                    <p class="text-xs text-[#8A9C91] mt-1">Top 5 souvenir dari pembayaran terverifikasi.</p>
                </div>

                @if ($souvenirSales->isEmpty())
                    <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl text-center">
                        <p class="text-sm text-[#8A9C91]">Belum ada penjualan souvenir terverifikasi pada periode ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-[#E6E4DD] text-[#8A9C91] text-xs uppercase tracking-wider">
                                    <th class="pb-3">Souvenir</th>
                                    <th class="pb-3 text-right">Terjual</th>
                                    <th class="pb-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F2F0EA]">
                                @foreach ($souvenirSales as $item)
                                    <tr>
                                        <td class="py-4 font-semibold text-[#2C3E35]">{{ $item->nama_item }}</td>
                                        <td class="py-4 text-right text-[#5C6E65]">{{ $item->total_terjual }} pcs</td>
                                        <td class="py-4 text-right font-semibold text-[#2B4C3F]">
                                            Rp {{ number_format((float) $item->total_penjualan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-xl font-serif font-semibold text-[#2C3E35]">Status Reservasi Homestay</h2>
                    <p class="text-xs text-[#8A9C91] mt-1">Distribusi status booking homestay pada periode terpilih.</p>
                </div>

                <div class="space-y-3">
                    @foreach ($reservationStatusCounts as $status => $count)
                        <div class="flex items-center justify-between gap-4 rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] px-4 py-3">
                            <span class="text-sm font-semibold text-[#2C3E35]">{{ $statusLabels[$status] ?? str_replace('_', ' ', $status) }}</span>
                            <span class="text-sm font-bold text-[#2B4C3F]">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-xl font-serif font-semibold text-[#2C3E35]">Pembayaran Terverifikasi Terbaru</h2>
                <p class="text-xs text-[#8A9C91] mt-1">Riwayat pembayaran valid yang masuk ke perhitungan pendapatan.</p>
            </div>

            @if ($recentPayments->isEmpty())
                <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl text-center">
                    <p class="text-sm text-[#8A9C91]">Belum ada pembayaran terverifikasi pada periode ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#E6E4DD] text-[#8A9C91] text-xs uppercase tracking-wider">
                                <th class="pb-3">Kode Pesanan</th>
                                <th class="pb-3">Pelanggan</th>
                                <th class="pb-3">Jenis</th>
                                <th class="pb-3">Tanggal Bayar</th>
                                <th class="pb-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2F0EA]">
                            @foreach ($recentPayments as $pembayaran)
                                <tr>
                                    <td class="py-4 font-mono text-xs font-bold text-[#2B4C3F]">
                                        {{ $pembayaran->pemesanan->kode_pemesanan }}
                                    </td>
                                    <td class="py-4 text-[#2C3E35]">{{ $pembayaran->pemesanan->user->nama }}</td>
                                    <td class="py-4 text-[#5C6E65] capitalize">{{ $pembayaran->pemesanan->jenis_pemesanan }}</td>
                                    <td class="py-4 text-[#5C6E65]">{{ $pembayaran->tanggal_pembayaran->format('d M Y H:i') }}</td>
                                    <td class="py-4 text-right font-semibold text-[#2B4C3F]">
                                        Rp {{ number_format((float) $pembayaran->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
