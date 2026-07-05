@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
    @php
        $statusLabels = [
            \App\Models\Pembayaran::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            \App\Models\Pembayaran::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            \App\Models\Pembayaran::STATUS_TERVERIFIKASI => 'Terverifikasi',
            \App\Models\Pembayaran::STATUS_DITOLAK => 'Ditolak',
        ];
    @endphp

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Kelola Pembayaran</h1>
                    <p class="text-sm text-[#5C6E65] leading-relaxed">
                        Verifikasi pembayaran pelanggan dan pantau status pemesanan.
                    </p>
                </div>

                <form action="{{ route('admin.pembayaran') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <select name="status"
                        class="bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $statusOption)
                            <option value="{{ $statusOption }}" @selected($status === $statusOption)>
                                {{ $statusLabels[$statusOption] ?? str_replace('_', ' ', $statusOption) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                        Filter
                    </button>
                </form>
            </div>

            @if ($pembayarans->isEmpty())
                <div class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl text-center">
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Pembayaran</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm mx-auto">
                        Pembayaran yang dikirim pelanggan akan muncul di sini.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#E6E4DD] text-[#8A9C91] text-xs uppercase tracking-wider">
                                <th class="pb-3">Kode Pesanan</th>
                                <th class="pb-3">Pelanggan</th>
                                <th class="pb-3">Jumlah Bayar</th>
                                <th class="pb-3">Metode</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2F0EA]">
                            @foreach ($pembayarans as $pembayaran)
                                <tr class="hover:bg-[#FAF9F6] transition-colors">
                                    <td class="py-4 font-mono text-xs font-bold text-[#2B4C3F]">
                                        {{ $pembayaran->pemesanan->kode_pemesanan }}
                                    </td>
                                    <td class="py-4 text-[#2C3E35]">{{ $pembayaran->pemesanan->user->nama }}</td>
                                    <td class="py-4 font-semibold text-[#2C3E35]">
                                        Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-[#5C6E65]">{{ str_replace('_', ' ', $pembayaran->metode_pembayaran) }}</td>
                                    <td class="py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#EAF2EE] text-[#2B4C3F]">
                                            {{ $statusLabels[$pembayaran->status_pembayaran] ?? str_replace('_', ' ', $pembayaran->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('admin.pembayaran.show', $pembayaran->pembayaran_id) }}"
                                            class="text-xs font-semibold text-[#2B4C3F] hover:underline">
                                            Detail
                                        </a>
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
