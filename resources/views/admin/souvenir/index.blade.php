@extends('layouts.app')

@section('title', 'Kelola Souvenir')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                    Kelola Souvenir
                </h1>
                <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                    Pantau produk souvenir, stok barang, nilai inventory, dan data penjualan.
                </p>
            </div>

            <x-ui-button href="{{ route('admin.souvenir.create') }}" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Souvenir
            </x-ui-button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-3 mb-6">
            <div class="rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Produk</p>
                <p class="text-2xl font-bold text-[#2C3E35] mt-1">{{ number_format($inventorySummary['total_produk'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#A7C5B5] bg-[#EAF2EE] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#5C6E65]">Total Stok</p>
                <p class="text-2xl font-bold text-[#2B4C3F] mt-1">{{ number_format($inventorySummary['total_stok'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#F5C2C2] bg-[#FDF2F2] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#9B1C1C]">Stok Habis</p>
                <p class="text-2xl font-bold text-[#9B1C1C] mt-1">{{ number_format($inventorySummary['stok_habis'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#E6E4DD] bg-white px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Terjual</p>
                <p class="text-2xl font-bold text-[#2C3E35] mt-1">{{ number_format($inventorySummary['total_terjual'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#D8CBAA] bg-[#FFFCF2] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#7A6236]">Nilai Stok</p>
                <p class="text-xl font-bold text-[#5C4721] mt-1">Rp {{ number_format($inventorySummary['nilai_stok'], 0, ',', '.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 20px; padding: 12px 16px; background: #EAF2EE; border: 1px solid #B8DEC8; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                <svg width="16" height="16" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size: 0.82rem; font-weight: 600; color: #2B4C3F;">{{ session('success') }}</span>
            </div>
        @endif

        @if($souvenirs->isEmpty())
            <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                <span class="text-5xl mb-4">Produk</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Souvenir</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data souvenir yang tersedia saat ini.
                </p>
                <x-ui-button href="{{ route('admin.souvenir.create') }}" variant="primary">
                    Tambah Souvenir Pertama
                </x-ui-button>
            </div>
        @else
            {{-- Desktop & Tablet: Table --}}
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 60px;">#</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 90px;">Foto</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Souvenir</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Harga</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Stok</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Terjual</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nilai Stok</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($souvenirs as $souvenir)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;"
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding: 16px; color: #8A9C91; font-weight: 600; text-align: center;">
                                    {{ $loop->iteration }}
                                </td>
                                {{-- Foto --}}
                                <td style="padding: 16px;">
                                    @if($souvenir->foto)
                                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}"
                                             style="width: 64px; height: 50px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                    @else
                                        <div style="width: 64px; height: 50px; background: #FAF9F6; border: 1.5px solid #E6E4DD; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #8A9C91;">Item</div>
                                    @endif
                                </td>

                                {{-- Nama & Detail --}}
                                <td style="padding: 16px; max-width: 240px;">
                                    <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $souvenir->nama_souvenir }}
                                    </span>
                                    @if($souvenir->detail)
                                        <span style="display: block; font-size: 0.72rem; color: #8A9C91; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $souvenir->detail }}">
                                            {{ $souvenir->detail }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Harga --}}
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 5px 10px; font-size: 0.8rem; font-weight: 700; color: #2B4C3F;">
                                        Rp {{ number_format($souvenir->harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Stok --}}
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem; font-weight: 600;">
                                        {{ number_format($souvenir->stok, 0, ',', '.') }} pcs
                                    </span>
                                </td>

                                {{-- Terjual --}}
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem; font-weight: 600;">
                                        {{ number_format($souvenir->jumlah_terjual, 0, ',', '.') }} pcs
                                    </span>
                                </td>

                                {{-- Nilai Stok --}}
                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; background: #FFFCF2; border: 1px solid #D8CBAA; border-radius: 8px; padding: 5px 10px; font-size: 0.8rem; font-weight: 700; color: #5C4721;">
                                        Rp {{ number_format($souvenir->harga * $souvenir->stok, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 12px 16px; text-align: left;">
                                    <div class="inline-flex items-center gap-2">
                                        <x-ui-button href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}" variant="secondary" size="sm">
                                            Edit
                                        </x-ui-button>
                                        <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui-button type="submit" variant="danger" size="sm">
                                                Hapus
                                            </x-ui-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile: Card List --}}
            <div class="md:hidden space-y-4">
                @foreach($souvenirs as $souvenir)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            @if($souvenir->foto)
                                <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-20 h-16 object-cover rounded-lg border border-[#E6E4DD] flex-shrink-0">
                            @else
                                <div class="w-20 h-16 bg-white border border-[#E6E4DD] rounded-lg flex items-center justify-center text-xs font-bold text-[#8A9C91] flex-shrink-0">Item</div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $souvenir->nama_souvenir }}</h4>
                                <p class="text-xs text-[#8A9C91]">Stok {{ number_format($souvenir->stok, 0, ',', '.') }} pcs &bull; Terjual {{ number_format($souvenir->jumlah_terjual, 0, ',', '.') }} pcs</p>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-[#E6E4DD] grid grid-cols-2 gap-3">
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">Harga</span>
                                <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">Nilai Stok</span>
                                <span class="text-sm font-semibold text-[#5C4721]">Rp {{ number_format($souvenir->harga * $souvenir->stok, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2 border-t border-[#E6E4DD]/50">
                            <x-ui-button href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}" variant="secondary" size="sm">
                                Edit
                            </x-ui-button>
                            <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-ui-button type="submit" variant="danger" size="sm">
                                    Hapus
                                </x-ui-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection