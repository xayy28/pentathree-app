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
                    Halaman pengelolaan produk souvenir untuk panel administrasi Natasha Homestay.
                </p>
            </div>

            <a href="{{ route('admin.souvenir.create') }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Souvenir
            </a>
        </div>

        <form action="{{ route('admin.souvenir') }}" method="GET" class="mb-6 p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-2xl">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-3">
                <select name="status"
                    class="w-full bg-white text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-2.5 text-sm focus:border-[#2B4C3F] focus:outline-none">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusOption }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                    Filter
                </button>

                <a href="{{ route('admin.souvenir') }}"
                    class="bg-white hover:bg-[#F2F0EA] text-[#5C6E65] border border-[#E6E4DD] text-sm font-semibold px-5 py-2.5 rounded-xl transition-all text-center">
                    Reset
                </a>
            </div>
        </form>

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
                <span class="text-5xl mb-4">🏺</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Souvenir</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data souvenir yang sesuai dengan filter saat ini.
                </p>
                <a href="{{ route('admin.souvenir.create') }}" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                    Tambah Souvenir Pertama
                </a>
            </div>
        @else
            {{-- Desktop & Tablet: Table --}}
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 90px;">Foto</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Souvenir</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Harga</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Stok</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Status</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($souvenirs as $souvenir)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;"
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'"
                                onmouseout="this.style.background='transparent'">
                                {{-- Foto --}}
                                <td style="padding: 16px;">
                                    @if($souvenir->foto)
                                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}"
                                             style="width: 64px; height: 50px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                    @else
                                        <div style="width: 64px; height: 50px; background: #FAF9F6; border: 1.5px solid #E6E4DD; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🏺</div>
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
                                        {{ $souvenir->stok }} pcs
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td style="padding: 16px;">
                                    @if($souvenir->status === 'Tersedia')
                                        <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #EAF2EE; color: #2B4C3F; border: 1px solid #B8DEC8;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #2B4C3F; display: inline-block;"></span>
                                            Tersedia
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #FDF2F2; color: #9B1C1C; border: 1px solid #F5C2C2;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #E65F5F; display: inline-block;"></span>
                                            {{ $souvenir->status }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 12px 16px; text-align: left;">
                                    <div style="display: inline-flex; align-items: center; gap: 4px; background: #F7F6F2; border: 1px solid #E6E4DD; border-radius: 10px; padding: 4px;">
                                        <a href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}"
                                           title="Edit"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #5C6E65; background: transparent; transition: all 0.15s ease; text-decoration: none;"
                                           onmouseover="this.style.background='white'; this.style.color='#2B4C3F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                           onmouseout="this.style.background='transparent'; this.style.color='#5C6E65'; this.style.boxShadow='none';">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <div style="width: 1px; height: 16px; background: #E6E4DD;"></div>
                                        <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" style="display: inline;">
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

            {{-- Mobile: Card List --}}
            <div class="md:hidden space-y-4">
                @foreach($souvenirs as $souvenir)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            @if($souvenir->foto)
                                <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-20 h-16 object-cover rounded-lg border border-[#E6E4DD] flex-shrink-0">
                            @else
                                <div class="w-20 h-16 bg-white border border-[#E6E4DD] rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🏺</div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $souvenir->nama_souvenir }}</h4>
                                <p class="text-xs text-[#8A9C91]">{{ $souvenir->stok }} pcs tersedia</p>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-[#E6E4DD] flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">Harga</span>
                                <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                @if($souvenir->status === 'Tersedia')
                                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">Tersedia</span>
                                @else
                                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C]">{{ $souvenir->status }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2 border-t border-[#E6E4DD]/50">
                            <a href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}" class="px-3 py-1.5 text-xs font-semibold border border-[#E6E4DD] text-[#5C6E65] hover:bg-[#FAF9F6] rounded-lg transition-colors flex items-center gap-1">
                                Edit
                            </a>
                            <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" class="inline">
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
