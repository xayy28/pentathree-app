@extends('layouts.app')

@section('title', 'Kelola Homestay')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                    Kelola Homestay
                </h1>
                <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                    Halaman pengelolaan Homestay untuk panel administrasi Natasha Homestay.
                </p>
            </div>

            <a href="{{ route('admin.homestay.create') }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Homestay
            </a>
        </div>

        <form action="{{ route('admin.homestay') }}" method="GET" class="mb-6 p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-2xl">
            <input type="hidden" name="availability_month" value="{{ $availabilityMonth }}">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-3">
                <select name="kategori"
                    class="w-full bg-white text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-2.5 text-sm focus:border-[#2B4C3F] focus:outline-none">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->kategori_id }}" @selected((string) $kategori === (string) $category->kategori_id)>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                    Filter
                </button>

                <a href="{{ route('admin.homestay') }}"
                    class="bg-white hover:bg-[#F2F0EA] text-[#5C6E65] border border-[#E6E4DD] text-sm font-semibold px-5 py-2.5 rounded-xl transition-all text-center">
                    Reset
                </a>
            </div>
        </form>
        @php
            $calendarQuery = fn (string $month) => array_filter([
                'kategori' => $kategori,
                'status' => $status,
                'availability_month' => $month,
            ], fn ($value) => filled($value));

            $summaryCards = [
                ['label' => 'Kosong', 'value' => $availabilitySummary['available'], 'class' => 'bg-[#EAF2EE] border-[#B8DEC8] text-[#2B4C3F]'],
                ['label' => 'Berisi', 'value' => $availabilitySummary['booked'], 'class' => 'bg-[#F9D6D5] border-[#F0A09B] text-[#8A2E2E]'],
                ['label' => 'Tidak tersedia', 'value' => $availabilitySummary['unavailable'], 'class' => 'bg-[#F2F0EA] border-[#D5D3C7] text-[#5C6E65]'],
                ['label' => 'Total slot', 'value' => $availabilitySummary['total'], 'class' => 'bg-white border-[#E6E4DD] text-[#2C3E35]'],
            ];

            $stateClasses = [
                'available' => 'bg-[#EAF2EE] border-[#B8DEC8] text-[#2B4C3F]',
                'booked' => 'bg-[#F9D6D5] border-[#E65F5F] text-[#8A2E2E] hover:bg-[#F4C4C1]',
                'unavailable' => 'bg-[#F2F0EA] border-[#D5D3C7] text-[#8A9C91]',
            ];
            $statusLabels = \App\Models\Pemesanan::homestayStatusLabels();
        @endphp

        <div id="kalender-ketersediaan" class="mb-6 rounded-2xl border border-[#E6E4DD] bg-[#FAF9F6] p-5 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-serif font-semibold text-[#2C3E35] mb-2">
                        Kalender Ketersediaan Homestay
                    </h2>
                    <p class="text-sm text-[#5C6E65] leading-relaxed">
                        Pantau status kamar per tanggal dari halaman Kelola Homestay.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.homestay', $calendarQuery($previousMonth)) }}"
                        class="h-10 w-10 inline-flex items-center justify-center rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] text-[#2C3E35] text-sm font-semibold hover:bg-[#F2F0EA] transition-colors"
                        aria-label="Bulan sebelumnya">
                        &lt;
                    </a>
                    <div class="min-w-40 px-4 py-2 rounded-xl border border-[#E6E4DD] bg-white text-center">
                        <span class="text-sm font-bold text-[#2C3E35]">{{ $monthStart->format('F Y') }}</span>
                    </div>
                    <a href="{{ route('admin.homestay', $calendarQuery($nextMonth)) }}"
                        class="h-10 w-10 inline-flex items-center justify-center rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] text-[#2C3E35] text-sm font-semibold hover:bg-[#F2F0EA] transition-colors"
                        aria-label="Bulan berikutnya">
                        &gt;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                @foreach($summaryCards as $card)
                    <div class="rounded-xl border px-4 py-3 {{ $card['class'] }}">
                        <p class="text-[10px] font-bold uppercase tracking-wider opacity-80">{{ $card['label'] }}</p>
                        <p class="text-2xl font-bold mt-1">{{ $card['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3 text-xs text-[#5C6E65] mb-4">
                <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-[#EAF2EE] border border-[#B8DEC8]"></span>Kosong</span>
                <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-[#F9D6D5] border border-[#E65F5F]"></span>Berisi</span>
                <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-[#F2F0EA] border border-[#D5D3C7]"></span>Tidak tersedia</span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-[#E6E4DD]">
                <div class="grid min-w-max text-xs"
                    style="grid-template-columns: 220px repeat({{ $calendarDays->count() }}, minmax(2.5rem, 2.5rem));">
                    <div class="sticky left-0 z-[2] bg-[#F7F6F2] border-r border-b border-[#E6E4DD] px-4 py-3 font-bold uppercase tracking-wider text-[#8A9C91]">
                        Homestay
                    </div>
                    @foreach($calendarDays as $day)
                        <div class="border-b border-[#E6E4DD] px-2 py-2 text-center {{ $day->isWeekend() ? 'bg-[#FBF7EE]' : 'bg-[#F7F6F2]' }}">
                            <div class="font-bold text-[#2C3E35]">{{ $day->format('d') }}</div>
                            <div class="text-[9px] uppercase text-[#8A9C91]">{{ $day->format('D') }}</div>
                        </div>
                    @endforeach

                    @foreach($availabilityRows as $row)
                        <div class="sticky left-0 z-[1] bg-white border-r border-b border-[#F2F0EA] px-4 py-3">
                            <div class="font-semibold text-[#2C3E35] truncate" title="{{ $row['homestay']->nama_homestay }}">
                                {{ $row['homestay']->nama_homestay }}
                            </div>
                            <div class="mt-1 text-[10px] text-[#8A9C91]">
                                {{ $row['available_count'] }} kosong | {{ $row['booked_count'] }} berisi
                            </div>
                        </div>

                        @foreach($row['days'] as $day)
                            @php
                                $detail = $day['detail'];
                                $title = $day['label'];

                                if ($detail) {
                                    $title = $detail['pelanggan'].' | '.$detail['check_in'].' - '.$detail['check_out'].' | '.($statusLabels[$detail['status']] ?? str_replace('_', ' ', $detail['status']));
                                }
                            @endphp

                            @if($day['state'] === 'booked' && $detail)
                                <a href="{{ route('admin.reservasi.show', $detail['pemesanan_id']) }}"
                                    class="h-10 border-b border-r border-[#F2F0EA] flex items-center justify-center font-semibold transition-colors {{ $stateClasses[$day['state']] }}"
                                    title="{{ $title }}">
                                    {{ $day['day']->format('d') }}
                                </a>
                            @else
                                <div class="h-10 border-b border-r border-[#F2F0EA] flex items-center justify-center font-semibold {{ $stateClasses[$day['state']] }}"
                                    title="{{ $title }}">
                                    {{ $day['day']->format('d') }}
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        @if($homestays->isEmpty())
            <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                <span class="text-5xl mb-4">🏠</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Homestay</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data homestay yang sesuai dengan filter saat ini.
                </p>
                <a href="{{ route('admin.homestay.create') }}" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                    Tambah Homestay Pertama
                </a>
            </div>
        @else
            <!-- Desktop & Tablet: Table -->
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 90px;">Foto</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Homestay</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Kategori</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Harga / Malam</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Kapasitas</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($homestays as $i => $homestay)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;" 
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'" 
                                onmouseout="this.style.background='transparent'">
                                <!-- Foto -->
                                <td style="padding: 16px;">
                                    @if($homestay->foto)
                                        <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" 
                                             style="width: 64px; height: 50px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                    @else
                                        <div style="width: 64px; height: 50px; background: #FAF9F6; border: 1.5px solid #E6E4DD; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🏠</div>
                                    @endif
                                </td>

                                <!-- Nama & Detail -->
                                <td style="padding: 16px; max-width: 240px;">
                                    <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $homestay->nama_homestay }}
                                    </span>
                                    @if($homestay->detail)
                                        <span style="display: block; font-size: 0.72rem; color: #8A9C91; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $homestay->detail }}">
                                            {{ $homestay->detail }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Kategori -->
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-weight: 600; font-size: 0.8rem; background: #FAF9F6; border: 1px solid #E6E4DD; padding: 4px 10px; border-radius: 8px;">
                                        {{ $homestay->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <!-- Harga -->
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 5px 10px; font-size: 0.8rem; font-weight: 700; color: #2B4C3F;">
                                        Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}
                                    </span>
                                </td>

                                <!-- Kapasitas -->
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem;">
                                        <svg width="14" height="14" fill="none" stroke="#8A9C91" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $homestay->kapasitas }} Orang
                                    </span>
                                </td>
                                <!-- Aksi -->
                                <td style="padding: 12px 16px; text-align: left;">
                                    <div style="display: inline-flex; align-items: center; gap: 4px; background: #F7F6F2; border: 1px solid #E6E4DD; border-radius: 10px; padding: 4px;">
                                        <a href="{{ route('admin.homestay.edit', $homestay->homestay_id) }}" 
                                           title="Edit"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #5C6E65; background: transparent; transition: all 0.15s ease; text-decoration: none;"
                                           onmouseover="this.style.background='white'; this.style.color='#2B4C3F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                           onmouseout="this.style.background='transparent'; this.style.color='#5C6E65'; this.style.boxShadow='none';">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <div style="width: 1px; height: 16px; background: #E6E4DD;"></div>
                                        <form action="{{ route('admin.homestay.destroy', $homestay->homestay_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus homestay ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #8A9C91; background: transparent; cursor: pointer; transition: all 0.15s ease;"
                                                    onmouseover="this.style.background='#FDF2F2'; this.style.color='#E65F5F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                                    onmouseout="this.style.background='transparent'; this.style.color='#8A9C91'; this.style.boxShadow='none';">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile: Card List -->
            <div class="md:hidden space-y-4">
                @foreach($homestays as $homestay)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            @if($homestay->foto)
                                <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-20 h-16 object-cover rounded-lg border border-[#E6E4DD] flex-shrink-0">
                            @else
                                <div class="w-20 h-16 bg-white border border-[#E6E4DD] rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🏠</div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $homestay->nama_homestay }}</h4>
                                <p class="text-xs text-[#8A9C91]">{{ $homestay->kapasitas }} Orang &bull; {{ $homestay->kategori->nama_kategori ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-[#E6E4DD] flex items-center">
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">Mulai dari</span>
                                <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2 border-t border-[#E6E4DD]/50">
                            <a href="{{ route('admin.homestay.edit', $homestay->homestay_id) }}" class="px-3 py-1.5 text-xs font-semibold border border-[#E6E4DD] text-[#5C6E65] hover:bg-[#FAF9F6] rounded-lg transition-colors flex items-center gap-1">
                                Edit
                            </a>
                            <form action="{{ route('admin.homestay.destroy', $homestay->homestay_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus homestay ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-[#E65F5F]/10 text-[#FF9E9E] hover:bg-[#E65F5F] hover:text-white rounded-lg transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
