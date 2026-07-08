@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#2B4C3F] to-[#1E362C] rounded-2xl p-6 sm:p-10 text-white shadow-md relative overflow-hidden">
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-10 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-white to-transparent pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-3xl sm:text-4xl font-serif font-semibold mb-2">Dashboard Overview</h1>
            <p class="text-[#A7C5B5] text-sm sm:text-base max-w-xl leading-relaxed">
                Selamat datang kembali di panel administrasi. Berikut ringkasan bisnis Natasha Homestay.
            </p>
            <div class="flex flex-wrap gap-4 mt-4 text-xs text-[#A7C5B5]">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ $pemesananHariIni }} pesanan hari ini
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $pembayaranMenunggu }} verifikasi pending
                </span>
            </div>
        </div>
    </div>

    {{-- Stat Cards Row 1: 4 main cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#2B4C3F]/5 rounded-bl-full -mr-8 -mt-8 group-hover:bg-[#2B4C3F]/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Homestay</span>
                <div class="p-2.5 bg-[#EAF2EE] rounded-xl text-[#2B4C3F]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
            </div>
            <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalHomestay }}</div>
            <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                <span class="text-[#2B4C3F] font-bold">+{{ $homestayBaruBulanIni }}</span> baru bulan ini
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#D4A853]/5 rounded-bl-full -mr-8 -mt-8 group-hover:bg-[#D4A853]/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Souvenir</span>
                <div class="p-2.5 bg-[#FBF3E8] rounded-xl text-[#D4A853]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalSouvenir }}</div>
            <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                <span class="text-[#2B4C3F] font-bold">{{ $souvenirTersedia }} tersedia</span> &bull; {{ $souvenirHabis }} habis
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#3B82F6]/5 rounded-full -mr-8 -mt-8 group-hover:bg-[#3B82F6]/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Reservasi</span>
                <div class="p-2.5 bg-[#E8F0FE] rounded-xl text-[#3B82F6]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalReservasi }}</div>
            <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                <span class="text-[#2B4C3F] font-bold">{{ $reservasiAktif }} aktif</span> perlu dipantau
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#8B5CF6]/5 rounded-full -mr-8 -mt-8 group-hover:bg-[#8B5CF6]/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Rating</span>
                <div class="p-2.5 bg-[#F3EEFF] rounded-xl text-[#8B5CF6]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.518-4.674z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ number_format($avgRating, 1) }}</div>
            <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                <span class="text-[#2B4C3F] font-bold">{{ $totalUlasan }} ulasan</span> dari pelanggan
            </p>
        </div>
    </div>

    {{-- Stat Cards Row 2:}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-[#E6E4DD] shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91] mb-1.5">Pendapatan Bulan Ini</div>
            <div class="text-xl font-serif font-semibold text-[#2C3E35]">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            @php $growth = $pendapatanBulanLalu > 0 ? round(($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu * 100, 1) : 0; @endphp
            <p class="text-[11px] text-[#5C6E65] mt-1 flex items-center gap-1">
                @if ($growth > 0)
                    <span class="text-emerald-600 font-bold">&uarr; {{ $growth }}%</span>
                @elseif ($growth < 0)
                    <span class="text-red-500 font-bold">&darr; {{ abs($growth) }}%</span>
                @else
                    <span class="text-[#8A9C91]">&mdash;</span>
                @endif
                dari bulan lalu
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-5 shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91] mb-1.5">Pendapatan Hari Ini</div>
            <div class="text-xl font-serif font-semibold text-[#2C3E35]">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            <p class="text-[11px] text-[#5C6E65] mt-1">{{ $pembayaranHariIni }} transaksi hari ini</p>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-5 shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91] mb-1.5">Pengguna</div>
            <div class="text-xl font-serif font-semibold text-[#2C3E35]">{{ $totalUser }}</div>
            <p class="text-[11px] text-[#5C6E65] mt-1">
                {{ $userAdmin }} admin &bull; {{ $userPelanggan }} pelanggan
                @if ($userBaruHariIni > 0)
                    &bull; <span class="text-[#2B4C3F] font-bold">+{{ $userBaruHariIni }}</span> hari ini
                @endif
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-5 shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91] mb-1.5">Ulasan</div>
            <div class="text-xl font-serif font-semibold text-[#2C3E35]">{{ $totalUlasan }}</div>
            <p class="text-[11px] text-[#5C6E65] mt-1">
                <span class="text-[#2B4C3F] font-bold">{{ $ulasanBulanIni }}</span> bulan ini
                @if ($ulasanHariIni > 0)
                    &bull; <span class="text-[#2B4C3F] font-bold">+{{ $ulasanHariIni }}</span> hari ini
                @endif
            </p>
        </div>
    </div>

    {{-- Section: Homestay & Souvenir Status Distribution --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Distribusi Reservasi Homestay</h3>
            @php $orderStats = $orderStats->toArray(); @endphp
            @if (count($orderStats) > 0)
                @php $orderTotal = array_sum($orderStats); @endphp
                <div class="space-y-2.5">
                    @foreach ($homestayStatusLabels as $key => $label)
                        @php $val = $orderStats[$key] ?? 0; $pct = $orderTotal > 0 ? round($val / $orderTotal * 100) : 0; @endphp
                        @if ($val > 0)
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-[#2C3E35] font-medium">{{ $label }}</span>
                                    <span class="text-[#5C6E65]">{{ $val }} ({{ $pct }}%)</span>
                                </div>
                                <div class="w-full h-2 bg-[#F2F0EA] rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 @switch($key)
                                        @case('menunggu_pembayaran') bg-yellow-400 @break
                                        @case('menunggu_verifikasi') bg-blue-400 @break
                                        @case('dikonfirmasi') bg-emerald-500 @break
                                        @case('sedang_menginap') bg-violet-400 @break
                                        @case('selesai') bg-green-600 @break
                                        @case('dibatalkan') bg-red-400 @break
                                        @default bg-gray-400
                                    @endswitch" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada reservasi homestay.</p>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Distribusi Pesanan Souvenir</h3>
            @php $souvenirStats = $souvenirOrderStats->toArray(); @endphp
            @if (count($souvenirStats) > 0)
                @php $souvenirTotal = array_sum($souvenirStats); @endphp
                <div class="space-y-2.5">
                    @foreach ($souvenirStatusLabels as $key => $label)
                        @php $val = $souvenirStats[$key] ?? 0; $pct = $souvenirTotal > 0 ? round($val / $souvenirTotal * 100) : 0; @endphp
                        @if ($val > 0)
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-[#2C3E35] font-medium">{{ $label }}</span>
                                    <span class="text-[#5C6E65]">{{ $val }} ({{ $pct }}%)</span>
                                </div>
                                <div class="w-full h-2 bg-[#F2F0EA] rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 @if($key === 'menunggu_pembayaran') bg-yellow-400 @elseif($key === 'menunggu_verifikasi') bg-blue-400 @elseif(in_array($key, ['terverifikasi','diproses'])) bg-emerald-400 @elseif($key === 'siap_diambil_dikirim') bg-orange-400 @elseif($key === 'selesai') bg-green-600 @elseif($key === 'dibatalkan') bg-red-400 @else bg-gray-400 @endif" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada pesanan souvenir.</p>
            @endif
        </div>
    </div>

    {{-- Section: Check-in Mendatang + Ulasan Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Check-in Mendatang</h3>
            @forelse ($upcomingCheckins as $order)
                <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-[#F2F0EA]' : '' }}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-[#EAF2EE] flex items-center justify-center text-[#2B4C3F]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2C3E35] truncate">{{ $order->user?->nama ?? '—' }}</p>
                        <p class="text-[11px] text-[#8A9C91]">
                            @foreach ($order->detailPemesanans as $d)
                                {{ $d->homestay?->nama_homestay }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                            &bull; {{ $order->detailPemesanans->first()?->check_in?->isoFormat('D MMM') ?? '—' }}
                        </p>
                    </div>
                    <span class="text-[10px] font-bold text-[#2B4C3F] bg-[#EAF2EE] px-2 py-0.5 rounded-full">
                        {{ $order->detailPemesanans->first()?->jumlah_malam ?? '—' }} malam
                    </span>
                </div>
            @empty
                <p class="text-sm text-[#8A9C91] text-center py-6">Tidak ada check-in mendatang.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-serif font-semibold text-[#2C3E35]">Ulasan Terbaru</h3>
                @if ($totalUlasan > 0)
                    <span class="text-[10px] font-bold text-[#8A9C91]">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($avgRating) ? 'text-[#D4A853]' : 'text-[#E6E4DD]' }}">★</span>
                        @endfor
                        {{ number_format($avgRating, 1) }}
                    </span>
                @endif
            </div>
            @forelse ($ulasanTerbaru as $ulasan)
                <div class="py-2.5 {{ !$loop->last ? 'border-b border-[#F2F0EA]' : '' }}">
                    <div class="flex items-start gap-2.5">
                        <div class="flex-shrink-0">
                            <div class="w-7 h-7 rounded-full bg-[#EAF2EE] flex items-center justify-center text-[10px] font-bold text-[#2B4C3F]">
                                {{ strtoupper(substr($ulasan->user?->nama ?? '?', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 text-xs">
                                <span class="font-semibold text-[#2C3E35]">{{ $ulasan->user?->nama ?? '—' }}</span>
                                <span class="text-[10px] text-[#D4A853]">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= ($ulasan->rating ?? 0) ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            <p class="text-[11px] text-[#5C6E65] mt-0.5 line-clamp-2">{{ $ulasan->ulasan ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>

    {{-- Section: Top Homestay by Rating & Populer Homestay --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Homestay Rating Tertinggi</h3>
            @forelse ($topHomestayByRating as $h)
                <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-[#F2F0EA]' : '' }}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#F3EEFF] flex items-center justify-center text-[11px] font-bold text-[#8B5CF6]">
                        {{ $loop->iteration }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2C3E35] truncate">{{ $h->nama_homestay }}</p>
                        <p class="text-[11px] text-[#D4A853]">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($h->ulasans_avg_rating ?? 0) ? 'text-[#D4A853]' : 'text-[#E5E4DD]' }}">★</span>
                            @endfor
                            <span class="text-[#8A9C91] ml-1">{{ number_format($h->ulasans_avg_rating, 1) }}</span>
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada rating homestay.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Homestay Terpopuler</h3>
            @forelse ($popularHomestays as $h)
                <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-[#F2F0EA]' : '' }}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#EAF2EE] flex items-center justify-center text-[11px] font-bold text-[#2B4C3F]">
                        {{ $loop->iteration }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2C3E35] truncate">{{ $h->nama_homestay }}</p>
                        <p class="text-[11px] text-[#5C6E65]">{{ $h->total_booking }} pemesanan &bull; Rp {{ number_format($h->harga_permalam, 0, ',', '.') }}/malam</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada pemesanan homestay.</p>
            @endforelse
        </div>
    </div>

    {{-- Section: Revenue Trend & Pendapatan per Kategori --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Tren Pendapatan 6 Bulan</h3>
            @php $hasRevenue = collect($revenueTrend)->sum('total') > 0; @endphp
            @if ($hasRevenue)
                <div class="flex items-end gap-1.5 h-40 pt-2">
                    @php $maxRev = max(collect($revenueTrend)->pluck('total')->max(), 1); @endphp
                    @foreach ($revenueTrend as $r)
                        @php $pct = max(round(($r['total'] / $maxRev) * 100), 2); @endphp
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-[9px] font-semibold text-[#2C3E35]">{{ $pct > 15 ? 'Rp'.number_format($r['total'], 0, ',', '.') : '' }}</span>
                            <div class="w-full bg-[#EAF2EE] rounded-t-lg overflow-hidden relative" style="height: 10rem;">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-[#2B4C3F] to-[#4B7A66] rounded-t-lg transition-all duration-500 hover:opacity-80" style="height: {{ $pct }}%;"></div>
                            </div>
                            <span class="text-[9px] text-[#5C6E65] font-medium mt-1">{{ $r['bulan'] }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-[#8A9C91] text-center py-10">Belum ada data pendapatan 6 bulan terakhir.</p>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Pendapatan per Kategori</h3>
            @php $homestayRev6 = collect($revenueTrendHomestay)->sum('total'); $souvenirRev6 = collect($revenueTrendSouvenir)->sum('total'); $totalRev6 = $homestayRev6 + $souvenirRev6; @endphp
            @if ($totalRev6 > 0)
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-[#2C3E35]">Homestay</span>
                            <span class="text-[#5C6E65]">Rp {{ number_format($homestayRev6, 0, ',', '.') }} ({{ round($homestayRev6 / $totalRev6 * 100) }}%)</span>
                        </div>
                        <div class="w-full h-3 bg-[#F2F0EA] rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#2B4C3F] to-[#D4A853]" style="width: {{ $totalRev6 > 0 ? round($homestayRev6 / $totalRev6 * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-[#2C3E35]">Souvenir</span>
                            <span class="text-[#5C6E65]">Rp {{ number_format($souvenirRev6, 0, ',', '.') }} ({{ round($souvenirRev6 / $totalRev6 * 100) }}%)</span>
                        </div>
                        <div class="w-full h-3 bg-[#F2F0EA] rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#D4A853] to-[#F59E0B]" style="width: {{ $totalRev6 > 0 ? round($souvenirRev6 / $totalRev6 * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-sm text-[#8A9C91] text-center py-10">Belum ada data pendapatan.</p>
            @endif
        </div>
    </div>

    {{-- Section: Pesanan Terbaru & Souvenir Terlaris --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-serif font-semibold text-[#2C3E35]">Pesanan Terbaru</h3>
                    <p class="text-xs text-[#8A9C91] mt-0.5">5 pesanan terakhir</p>
                </div>
                <a href="{{ route('admin.reservasi') }}" class="text-xs font-semibold text-[#2B4C3F] hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-[10px] uppercase tracking-wider">
                            <th class="pb-3 pr-2">Kode</th>
                            <th class="pb-3 pr-2">Pelanggan</th>
                            <th class="pb-3 pr-2">Tipe</th>
                            <th class="pb-3 pr-2">Total</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-[#FAF9F6] transition-colors">
                                <td class="py-3 pr-2 font-mono text-xs font-semibold text-[#2B4C3F]">{{ $order->kode_pemesanan }}</td>
                                <td class="py-3 pr-2 text-sm">{{ $order->user?->nama ?? '—' }}</td>
                                <td class="py-3 pr-2">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full {{ $order->jenis_pemesanan === 'homestay' ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'bg-[#FBF3E8] text-[#D4A853]' }}">
                                        {{ $order->jenis_pemesanan }}
                                    </span>
                                </td>
                                <td class="py-3 pr-2 font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="py-3">
                                    @php
                                    $_label = $statusLabels[$order->status_pemesanan] ?? $order->status_pemesanan;
                                    $_colors = [
                                        'menunggu_pembayaran' => 'bg-[#FFF8E1] text-[#F59E0B] border border-[#FCD34D]',
                                        'menunggu_verifikasi' => 'bg-[#E8F0FE] text-[#3B82F6] border border-[#93C5FD]',
                                        'dikonfirmasi' => 'bg-[#EAF2EE] text-[#2B4C3F] border border-[#B8DEC8]',
                                        'terverifikasi' => 'bg-[#EAF2EE] text-[#2B4C3F] border border-[#B8DEC8]',
                                        'diproses' => 'bg-[#F3EEFF] text-[#8B5CF6] border border-[#C4B5FD]',
                                        'sedang_menginap' => 'bg-[#F3EEFF] text-[#8B5CF6] border border-[#C4B5FD]',
                                        'selesai' => 'bg-[#E8F5E9] text-[#2E7D32] border border-[#A5D6A7]',
                                        'dibatalkan' => 'bg-[#FDE8E8] text-[#DC2626] border border-[#FCA5A5]',
                                        'kedaluwarsa' => 'bg-[#F5F5F5] text-[#9CA3AF] border border-[#D4D4D8]',
                                        'siap_diambil_dikirim' => 'bg-[#FFF3E0] text-[#E65100] border border-[#FFB74D]',
                                    ];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $_colors[$order->status_pemesanan] ?? 'bg-[#F5F5F5] text-[#6B7280] border border-[#D4D4D8]' }}">
                                        {{ $_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-sm text-[#8A9C91]">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Souvenir Terlaris</h3>
            @forelse ($topSouvenirs as $i => $s)
                <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-[#F2F0EA]' : '' }}">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold {{ $i === 0 ? 'bg-[#D4A853] text-white' : ($i === 1 ? 'bg-[#CBD5E1] text-white' : ($i === 2 ? 'bg-[#D68C45] text-white' : 'bg-[#E6E4DD] text-[#5C6E65]')) }}">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2C3E35] truncate">{{ $s->nama_souvenir }}</p>
                        <p class="text-[11px] text-[#8A9C91]">{{ $s->jumlah_terjual }} terjual &bull; Rp {{ number_format($s->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#8A9C91] text-center py-6">Belum ada penjualan souvenir.</p>
            @endforelse
            @if ($souvenirTerjualBulanIni > 0)
                <div class="mt-3 pt-3 border-t border-[#F2F0EA] text-[11px] text-[#5C6E65]">
                    {{ $souvenirTerjualBulanIni }} terjual bulan ini
                </div>
            @endif
        </div>
    </div>

    {{-- Section: Pembayaran & Verifikasi Terbaru + Pengguna Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-serif font-semibold text-[#2C3E35]">Pembayaran Menunggu Verifikasi</h3>
                    <p class="text-xs text-[#8A9C91] mt-0.5">{{ $recentPayments->count() }} pembayaran perlu dicek</p>
                </div>
                <a href="{{ route('admin.pembayaran') }}" class="text-xs font-semibold text-[#2B4C3F] hover:underline">Verifikasi</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-[10px] uppercase tracking-wider">
                            <th class="pb-3 pr-2">Kode</th>
                            <th class="pb-3 pr-2">Pelanggan</th>
                            <th class="pb-3 pr-2">Jumlah</th>
                            <th class="pb-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @forelse ($recentPayments as $p)
                            <tr class="hover:bg-[#FAF9F6] transition-colors">
                                <td class="py-3 pr-2 font-mono text-xs font-semibold text-[#2B4C3F]">{{ $p->pemesanan?->kode_pemesanan ?? '—' }}</td>
                                <td class="py-3 pr-2 text-sm">{{ $p->pemesanan?->user?->nama ?? '—' }}</td>
                                <td class="py-3 pr-2 font-semibold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 text-xs text-[#5C6E65]">{{ $p->tanggal_pembayaran ? $p->tanggal_pembayaran->isoFormat('D MMM') : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-sm text-[#8A9C91]">Semua pembayaran sudah diverifikasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Pengguna Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-[10px] uppercase tracking-wider">
                            <th class="pb-3 pr-2">Nama</th>
                            <th class="pb-3 pr-2">Email</th>
                            <th class="pb-3">Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @forelse ($recentUsers as $user)
                            <tr class="hover:bg-[#FAF9F6] transition-colors">
                                <td class="py-3 pr-2 font-medium text-sm">
                                    {{ $user->nama }}
                                    @if ($user->is(auth()->user()))
                                        <span class="text-[#8A9C91] text-[10px]">(Anda)</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-2 text-xs text-[#5C6E65]">{{ $user->email }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full {{ $user->role === 'admin' ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-center text-sm text-[#8A9C91]">Belum ada user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Section: Verifikasi Terbaru & Pengguna Top Spender --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Pembayaran Terverifikasi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-[10px] uppercase tracking-wider">
                            <th class="pb-3 pr-2">Kode</th>
                            <th class="pb-3 pr-2">Pelanggan</th>
                            <th class="pb-3 pr-2">Jumlah</th>
                            <th class="pb-3">Verifikator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @forelse ($recentVerifiedPayments as $p)
                            <tr class="hover:bg-[#FAF9F6] transition-colors">
                                <td class="py-3 pr-2 font-mono text-xs font-semibold text-[#2B4C3F]">{{ $p->pemesanan?->kode_pemesanan ?? '—' }}</td>
                                <td class="py-3 pr-2 text-sm">{{ $p->pemesanan?->user?->nama ?? '—' }}</td>
                                <td class="py-3 pr-2 font-semibold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 text-xs text-[#5C6E65]">
    @if ($p->verifier)
        {{ $p->verifier->nama }}
    @elseif ($p->metode_pembayaran === 'midtrans')
        <span class="text-emerald-600 font-semibold">Otomatis</span>
    @else
        <span class="text-[#8A9C91]">—</span>
    @endif
</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-sm text-[#8A9C91]">Belum ada pembayaran terverifikasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Pelanggan Top Spender</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-[10px] uppercase tracking-wider">
                            <th class="pb-3 pr-2">#</th>
                            <th class="pb-3 pr-2">Nama</th>
                            <th class="pb-3">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        @forelse ($topUsers as $i => $u)
                            <tr class="hover:bg-[#FAF9F6] transition-colors">
                                <td class="py-3 pr-2 text-[10px] font-bold text-[#8A9C91]">{{ $i + 1 }}</td>
                                <td class="py-3 pr-2 text-sm font-medium text-[#2C3E35]">{{ $u->nama }}</td>
                                <td class="py-3 font-semibold">Rp {{ number_format($u->total_belanja ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-center text-sm text-[#8A9C91]">Belum ada data belanja.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Section: Rekap Cepat --}}
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
        <h3 class="text-base font-serif font-semibold text-[#2C3E35] mb-4">Rekap Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $homestayTersedia }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Homestay Tersedia</div>
            </div>
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $homestayTidakTersedia }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Homestay Tidak Aktif</div>
            </div>
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $pembayaranTerverifikasi }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Pembayaran Diverifikasi</div>
            </div>
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $pembayaranDitolak }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Pembayaran Ditolak</div>
            </div>
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $souvenirHabis }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Souvenir Habis</div>
            </div>
            <div class="text-center p-3 bg-[#FAF9F6] rounded-xl">
                <div class="text-lg font-serif font-semibold text-[#2C3E35]">{{ $souvenirStokMenipis }}</div>
                <div class="text-[10px] text-[#8A9C91] font-medium uppercase tracking-wider">Stok Menipis (&le;5)</div>
            </div>
        </div>
    </div>
</div>
@endsection